<?php
class Phergie_Plugin_Anime extends Phergie_Plugin_Abstract
{
	/**
	 * PDO resource for a SQLite database.
	 *
	 * @var resource
	 */
	protected $db;

	/**
	 * Array with channels's last activity
	 */
	protected $channelsStatus = array();

	/**
	 * Time of last delivery
	 */
	protected $lastDeliveryTime = 0;

	/**
	 * Checks for dependencies, set default values and starts Cron callback
	 *
	 * @return void
	 */
	public function onLoad()
	{
		// Database stuff
		if (! extension_loaded('PDO') || ! extension_loaded('pdo_sqlite'))
		{
			$this->fail('PDO and pdo_sqlite extensions must be installed');
		}

		$defaultDbLocation = dirname(__FILE__) . '/Anime/anime.db';

		$fileName = $this->getConfig('anime.sqlite_db', $defaultDbLocation);
		$dirName = dirname($fileName);

		$exists = file_exists($fileName);
		if (! file_exists($dirName))
		{
			mkdir($dirName);
		}

		if ((file_exists($fileName) && ! is_writable($fileName))
			|| (! file_exists($fileName) && ! is_writable($dirName))
		)
		{
			throw new Phergie_Plugin_Exception(
				'SQLite DB file exists and cannot be written,'
					. ' OR does not exist and cannot be created: '
					. $fileName
			);
		}

		try
		{
			$this->db = new PDO('sqlite:' . $fileName);
			$this->createTables();
		} catch (PDO_Exception $e)
		{
			throw new Phergie_Plugin_Exception($e->getMessage());
		}

		// Registering a Cron Callback
		$this->plugins->getPlugin('Cron')->registerCallback(
			array($this, 'animeCheckingCallback'),
			3,
			array(),
			true
		);
	}


	/**
	 * Cron callback to check the feed
	 *
	 * @return void
	 */
	public function animeCheckingCallback()
	{
		$endPoint = trim($this->getConfig('Anime.api', 'http://localhost/'), '/');
		$data = json_decode(file_get_contents($endPoint . '/checked/now?json'));
		$text="";
		foreach ($data as $program)
		{
			$time = strtotime($program->startTime);
			if (time() + 60 * 5 < $time || time() - 60 * 5 > $time)
				continue;
			$result = $this->db->query(sprintf("SELECT * FROM anime_noticed WHERE programId = %d",(int)$program->id));
			if($result->fetchAll())
				continue;
			$text = sprintf("%s [%s]%s ", date("H:i", strtotime($program->startTime)), $program->channel->name, $program->title->title);
			break;
		}
		if(!$text)
			return;


		foreach ($this->channelsStatus as $channel => $channelTime)
		{
			$this->doPrivmsg($channel, $text);
		}
		$result = $this->db->query(sprintf("INSERT INTO anime_noticed values(%d)",(int)$program->id));
		return;
	}


	/**
	 * Check if the feed is valid, updated and returns the content + header
	 *
	 * @param string $url     Feed URL
	 * @param string $updated Last time this feed was checked
	 * @param string $etag    Last etag of this feed
	 *
	 * @return FeedParser
	 */
	public function getFeed($url, $updated = 0, $etag = '')
	{
		$http = $this->plugins->getPlugin('Http');

		// If $updated AND $etag are not provide,
		// don't make the head request and avoid an useless request
		if (! empty($updated) OR ! empty($etag))
		{
			$response = $http->head($url);

			if ($response->getCode() == '200')
			{
				$header = $response->getHeaders();

				if (! empty($header['last-modified']))
				{
					$lm = strtotime($header['last-modified']);
					if ($lm < $updated)
					{
						return false;
					}
				}
				else if (isset($header['etag']) && $etag == $header['etag'])
				{
					return false;
				}
			}
			else
			{
				echo 'ERROR(Feed): ' . $url . ' - ' .
					$response->getCode() . ' - ' .
					$response->getMessage() . PHP_EOL;
				return false;
			}
		}

		// If the feed is updated, request the content
		$response = $http->get($url);
		if ($response->getCode() == '200')
		{
			return array(
				'content' => $response->getContent(),
				'header' => $response->getHeaders()
			);
		}
		else
		{
			echo 'ERROR(Feed): ' . $url . ' - ' .
				$response->getCode() . ' - ' .
				$response->getMessage() . PHP_EOL;
			return false;
		}
	}


	/**
	 * Get unread items from the database and delivery then
	 *
	 * @param String $channel ToDo desc
	 *
	 * @return void
	 */
	public function checkQueue($channel)
	{

		$items = $this->getUnreadItems($channel);
		if (empty($items))
		{
			return;
		}

		foreach ($items as $i)
		{
			$outputFormat = "[%source%] %title% [ %link% ] by %author% at %updated%";
			$outputFormat = $this->getConfig('FeedTicker.format', $outputFormat);
			$outputTimeFormat = $this->getConfig(
				'FeedTicker.timeFormat', "Y-m-d H:i"
			);
			$updated = date($outputTimeFormat, $i['updated']);
			$txt = str_replace(
				array('%source%', '%title%', '%link%', '%author%', '%updated%'),
				array($i['source'], $i['title'], $i['link'], $i['author'], $updated),
				$outputFormat
			);
			$this->doPrivmsg($channel, $txt);

			// Mark item as read
			$q = $this->db->prepare(
				'UPDATE ft_items SET read = 1 WHERE rowid = :rowid'
			);
			$q->execute(array('rowid' => $i['rowid']));
		}
	}


	/**
	 * Get all unread items from this channel
	 *
	 * @param String $channel ToDo desc
	 *
	 * @return array
	 */
	public function getUnreadItems($channel)
	{
		$feeds = $this->plugins->getPlugin('FeedManager')->getAllFeeds($channel);
		if (empty($feeds))
		{
			return;
		}

		$feed_ids = array();
		foreach ($feeds as $f)
		{
			$feed_ids[] = $f['rowid'];
		}

		$feed_ids = implode(',', $feed_ids);

		$showMaxItems = intval($this->getConfig('FeedTicker.showMaxItems', 2));

		$sql = 'SELECT I.rowid, I.feed_id, I.updated,
                    I.title, I.link, I.author, F.title as source
                FROM ft_items as I, ft_feeds as F
                WHERE I.read = 0 AND I.feed_id IN (' . $feed_ids . ')
                    AND I.feed_id = F.rowid
                ORDER BY I.updated ASC
                LIMIT ' . $showMaxItems;
		$result = $this->db->query($sql);
		return $result->fetchAll();
	}


	/**
	 * Determines if a table exists
	 *
	 * @param string $name Table name
	 *
	 * @return bool
	 */
	public function haveTable($name)
	{
		$sql = 'SELECT COUNT(*) FROM sqlite_master WHERE name = '
			. $this->db->quote($name);
		return (bool)$this->db->query($sql)->fetchColumn();
	}


	/**
	 * Creates the database table(s) (if they don't exist)
	 *
	 * @return void
	 */
	public function createTables()
	{
		if (! $this->haveTable('anime_noticed'))
		{
			$this->db->exec( 'CREATE TABLE anime_noticed ( programId INTEGER )' );
		}

//		if (! $this->haveTable('ft_feeds'))
//		{
//			$this->db->exec(
//				'CREATE TABLE ft_feeds (
//						updated INTEGER,
//						etag TEXT,
//						delay INTEGER,
//						channel TEXT,
//						title TEXT,
//						description TEXT,
//						link TEXT,
//						feed_url TEXT,
//						active BOOLEAN
//					)'
//			);
//		}
	}


	/**
	 * Check if the bot is not alone in this channel and set new channel Status
	 *
	 * @param String $channel TODO desc
	 *
	 * @return void
	 */
	public function setChannelStatus($channel)
	{
		$this->channelsStatus[$channel] = time();
	}


	/**
	 * Tracks users joining a channel
	 *
	 * @return void
	 */
	public function onJoin()
	{
		$this->setChannelStatus($this->event->getSource());
	}


	/**
	 * Tracks users leaving a channel
	 *
	 * @return void
	 */
	public function onPart()
	{
		$this->setChannelStatus($this->event->getSource());
	}


	/**
	 * Tracks users quitting a server
	 *
	 * @return void
	 */
	public function onQuit()
	{
		$this->setChannelStatus($this->event->getSource());
	}


	/**
	 * Tracks channel chat
	 *
	 * @return void
	 */
	public function onPrivmsg()
	{
		$this->channelsStatus[$this->event->getSource()] = time();
	}
}

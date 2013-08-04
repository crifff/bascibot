<?php
/**
 * Phergie
 *
 * PHP version 5
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://phergie.org/license
 *
 * @category  Phergie
 * @package   Phergie_Plugin_Url
 * @author    Phergie Development Team <team@phergie.org>
 * @copyright 2008-2012 Phergie Development Team (http://phergie.org)
 * @license   http://phergie.org/license New BSD License
 * @link      http://pear.phergie.org/package/Phergie_Plugin_Url
 */

/**
 * Monitors incoming messages for instances of URLs and responds with messages
 * containing relevant information about detected URLs.
 *
 * Has an utility method accessible via
 * $this->getPlugin('Url')->getTitle('http://foo..').
 *
 * @category Phergie
 * @package  Phergie_Plugin_Url
 * @author   Phergie Development Team <team@phergie.org>
 * @license  http://phergie.org/license New BSD License
 * @link     http://pear.phergie.org/package/Phergie_Plugin_Url
 * @uses     Phergie_Plugin_Encoding pear.phergie.org
 * @uses     Phergie_Plugin_Http pear.phergie.org
 * @uses     Phergie_Plugin_Tld pear.phergie.org
 * @uses     Phergie_Plugin_Cache pear.phergie.org
 */
class Phergie_Plugin_Url extends Phergie_Plugin_Abstract
{
    /**
     * Cache object to store cached URLs to prevent spamming, especially with more
     * than one bot on the same channel.
     *
     * @var Phergie_Plugin_Cache
     */
    protected $cache;

    /**
     * Time in seconds to store the cached entries
     *
     * Setting it to 0 or below disables the cache expiration
     *
     * @var int
     */
    protected $expire = 300;

    /**
     * Number of entries to keep in the cache at one time per channel
     *
     * Setting it to 0 or below disables the cache limit
     *
     * @var int
     */
    protected $limit = 10;

    /**
     * Flag that determines if the plugin will fall back to using an HTTP
     * stream when a URL using SSL is detected and OpenSSL support isn't
     * available in the PHP installation in use
     *
     * @var bool
     */
    protected $sslFallback = true;

    /**
     * Flag that is set to true by the custom error handler if an HTTP error
     * code has been received
     *
     * @var boolean
     */
    protected $errorStatus = false;
    protected $errorMessage = null;

    /**
     * Shortener object
     */
    protected $shortener;

    /**
     * Array of renderers
     */
    protected $renderers = array();

    /**
     * Checks for dependencies.
     *
     * @return void
     */
    public function onLoad()
    {
        $plugins = $this->plugins;
        $plugins->getPlugin('Encoding');
        $plugins->getPlugin('Http');
        $plugins->getPlugin('Tld');
        $plugins->getPlugin('Cache');

        // make the shortener configurable
        $shortener = $this->getConfig('url.shortener', 'Isgd');
        $shortener = "Phergie_Plugin_Url_Shorten_{$shortener}";
        $this->shortener = new $shortener($this->plugins->getPlugin('Http'));

        if (!$this->shortener instanceof Phergie_Plugin_Url_Shorten_Abstract) {
            $this->fail(
                "Declared shortener class {$shortener} is not of proper ancestry"
            );
        }

        $this->cache = $plugins->cache;
    }

    /**
     * Checks an incoming message for the presence of a URL and, if one is
     * found, responds with its title if it is an HTML document and the
     * shortened equivalent of its original URL if it meets length requirements.
     *
     * @return void
     */
    public function onPrivmsg()
    {
        $this->handleMsg();
    }

    /**
     * Checks an incoming message for the presence of a URL and, if one is
     * found, responds with its title if it is an HTML document and the
     * shortened equivalent of its original URL if it meets length requirements.
     *
     * @return void
     */
    public function onAction()
    {
        $this->handleMsg();
    }

    /**
     * Handles message events and responds with url titles.
     *
     * @return void
     */
    protected function handleMsg()
    {
        $source = $this->getEvent()->getSource();
        $user = $this->getEvent()->getNick();

        $responses = array();
	    $text = $this->getEvent()->getArgument(1);
	    preg_match('#https?://[^ ]+#',$text,$matches);
	    if(!$matches[0])return;
	    $html = file_get_contents($matches[0]);
	    $encode = mb_detect_encoding($html);
	    if(!$encode)return;
	    $html = mb_convert_encoding($html, 'UTF-8', $encode);
	    $html=preg_replace('/\r?\n/',' ',$html);
	    preg_match('/<title.*?>(.*?)<\/title>/i', $html, $matches);
	    if(!$matches[1])return;
	    $this->doNotice($source, '└'. $matches[1]);
	    return;
    }

    /**
     * Output a debug message
     *
     * @param string $msg the message to output
     *
     * @return void
     */
    protected function debug($msg)
    {
        echo "(DEBUG:Url) $msg\n";
    }

    /**
     * Add a renderer to the stack
     *
     * @param object $obj the renderer to add
     *
     * @return void
     */
    public function registerRenderer($obj)
    {
        $this->renderers[spl_object_hash($obj)] = $obj;
    }

    /**
     * Processes events before they are dispatched and tries to shorten any
     * urls in the text
     *
     * @return void
     */
    public function preDispatch()
    {
        if (!$this->getConfig('url.shortenOutput', false)) {
            return;
        }

        $events = $this->events->getEvents();

        foreach ($events as $event) {
            switch ($event->getType()) {
            case Phergie_Event_Request::TYPE_PRIVMSG:
            case Phergie_Event_Request::TYPE_ACTION:
            case Phergie_Event_Request::TYPE_NOTICE:
                $text = $event->getArgument(1);
                $urls = $this->findUrls($text);

                foreach ($urls as $parsed) {
                    $url = $parsed['glued'];

                    // shorten url
                    $shortenedUrl = $this->shortener->shorten($url);
                    if (!$shortenedUrl) {
                        $this->debug(
                            'Invalid Url: Unable to shorten. (' . $url . ')'
                        );
                        $shortenedUrl = $url;
                    }

                    $text = str_replace($url, $shortenedUrl, $text);
                }

                $event->setArgument(1, $text);
                break;
            }
        }
    }
}

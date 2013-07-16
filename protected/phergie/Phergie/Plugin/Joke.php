<?php
class Phergie_Plugin_Joke extends Phergie_Plugin_Abstract
{
	/**
	 * Checks for dependencies.
	 *
	 * @return void
	 */
	public function onLoad()
	{
		$this->getPluginHandler()->getPlugin('Command');
	}

	public function onCommandJoke($message = null)
	{
		$this->doPrivmsg(
			$this->getEvent()->getSource(),
			$this->joke()
		);
	}

	public function joke()
	{
		$texts = array(
			'ボブ『東尋坊さ』',
			'Ｃ「俺の勝ちだな。俺の彼女は性格もルックスも最高。唯一の欠点は、のどぼとけが異常に出ていることぐらいだ。」',
			'「ゼペットじいさんには悪いけど・・・僕の今の彼女は、この紙やすりさ。」',
			'「禁煙なんて簡単だよ。私はもう100回はやったね」',
			'博士「はい。2発目は。証拠隠滅用に・・・。」',
			'「妻が犯人です」',
			'「ということは、君はホモだな！！」',
			'「リンカーンはパパの年の頃には、アメリカの大統領だったよ」',
			'生徒「はーい。ワシントンはまだ斧を持っていたからだと思います」',
		);
		$key = array_rand($texts);
		return $texts[$key];
	}
}

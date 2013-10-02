<?php
//$GLOBALS['SMARTIRC_nreplycodes'] = array();
//require_once(dirname(__FILE__) . "/../../vendor/autoload.php");
require_once("Net/SmartIRC.php");
$GLOBALS['SMARTIRC_nreplycodes'] = $SMARTIRC_nreplycodes;

class RunCommand extends CConsoleCommand
{
    public function run($botId)
    {
        /** @var Bot $bot */
        $bot = Bot::model()->findByPk($botId);
        $irc = new Net_SmartIRC();

        $irc->setAutoRetry(true);
        $irc->setAutoReconnect(true);
        //        $irc->setChannelSyncing(true);
        $irc->setDebug(SMARTIRC_DEBUG_ALL);
        $irc->setLogdestination(SMARTIRC_STDOUT);

        //10000msec毎に$bot->timer()を呼ぶ
        $irc->registerTimehandler(3000, $bot, 'timer');
        //すべてのメッセージを$bot->reserveMessage()に渡す
        $irc->registerActionhandler(SMARTIRC_TYPE_ALL, '.*', $bot, 'reserveMessage');

        $irc->connect($bot->server, $bot->port);
        $irc->login($bot->nickName, $bot->realName);
        $irc->join('#' . $bot->channel);

        $irc->listen();
    }
}
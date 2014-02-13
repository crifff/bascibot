<?php

/**
 * Class Bot
 * @property string $nickName
 * @property string $realName
 * @property string $channel
 * @property string $server
 * @property int $id
 * @property int $port
 */
class Bot extends CActiveRecord
{
    private $noticed = array();

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'bot';
    }

    public function timer(Net_SmartIRC $irc)
    {
        $model = new Program('search');
        $model->unsetAttributes(); // clear any default values
        /** @var Program[] $programs */
        $programs = $model->now($this->id);
        foreach ($programs as $program) {
            if ($program->startTime &&
                strtotime($program->startTime) < time() + 60 * 5 &&
                strtotime($program->startTime) > time() - 60 * 1
            ) {
                if (!isset($this->noticed[$program->id])) {
                    $text = $this->flagText($program->flag) . sprintf(
                            "【!】 %s [%s] %s",
                            date("H:i", strtotime($program->startTime)),
                            $program->channel->name,
                            $program->title->title
                        );
                    if ($program->subTitle) {
                        $text .= sprintf(" 「%s」", $program->subTitle);
                    }
                    $this->say($irc, $text);
                    $this->noticed[$program->id] = true;
                }
            }
        }
    }

    private function flagText($flag)
    {
        $text = "";
        if ($flag & 1) {
            $text .= "【注】";
        }
        if ($flag & 2) {
            $text .= "【新】";
        }
        if ($flag & 4) {
            $text .= "【終】";
        }
        if ($flag & 8) {
            $text .= "【再】";
        }
        return $text;
    }

    public function hello(Net_SmartIRC $irc, $data)
    {
        $irc->message(SMARTIRC_TYPE_NOTICE, $data->channel, 'こんにちは');
    }

    public function reserveMessage(Net_SmartIRC $irc, $data)
    {
        if ($data->type != SMARTIRC_TYPE_CHANNEL) {
            return;
        }

        if (preg_match('/(?:^|[\s　]+)((?:https?|ftp):\/\/[^\s　]+)/', $data->message, $matches)) {
            $title = $this->getPageTitle($matches[1]);
            if ($title) {
                $this->notice($irc, $title);
            }
        }
    }

    private function getPageTitle($url)
    {
        return $response = file_get_contents('http://criff.net/api/getWebTitle.php?url=' . rawurlencode($url));
    }

    private function notice(Net_SmartIRC $irc, $message)
    {
        $irc->message(SMARTIRC_TYPE_NOTICE, '#' . $this->channel, $message);
    }

    private function say(Net_SmartIRC $irc, $message)
    {
        $irc->message(SMARTIRC_TYPE_CHANNEL, '#' . $this->channel, $message);
    }
}
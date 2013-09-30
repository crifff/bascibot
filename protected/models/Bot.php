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
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'bot';
    }

    public function timer($irc)
    {
        //10000ms毎に叩かれる
    }

    public function hello($irc, $data)
    {
        $irc->message(SMARTIRC_TYPE_NOTICE, $data->channel, 'こんにちは');
    }

    public function reserveMessage($irc, $data)
    {
        //すべてのメッセージをうけとるので保存とか返事とかいろいろできる
    }

}
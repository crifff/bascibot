<?php

class ProgramController extends Controller
{
    /** @var Bot */
    public $bot;

    protected function beforeAction($action)
    {
        $server = $_GET['server'];
        $channel = $_GET['channel'];
        $this->bot = Bot::model()->findByAttributes(array('server' => $server, 'channel' => $channel));
        return (bool)$this->bot;
    }

    /**
     * Lists all models.
     */
    public function actionIndex($server, $channel)
    {
        $model = new Program('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Program'])) {
            $model->attributes = $_GET['Program'];
        }

        $this->render(
            'index',
            array(
                'model' => $model,
                'server' => $this->bot->server,
                'channel' => $this->bot->channel,
                'botId' => $this->bot->id,
            )
        );
    }

    /**
     * @param int $titleId
     * @param int $channelId
     */
    public function actionCheck($server, $channel, $titleId, $channelId)
    {
        /** @var Check $check */
        $check = Check::model()->findByAttributes(
            array('titleId' => $titleId, 'channelId' => $channelId, 'botId' => $this->bot->id)
        );
        if (!$check) {
            $check = new Check();
        }
        $check->titleId = $titleId;
        $check->channelId = $channelId;
        $check->botId = $this->bot->id;
        $check->save();
    }

    /**
     * @param int $titleId
     * @param int $channelId
     */
    public function actionUnCheck($server, $channel, $titleId, $channelId)
    {
        $check = Check::model()->findByAttributes(
            array('titleId' => $titleId, 'channelId' => $channelId, 'botId' => $this->bot->id)
        );
        if ($check) {
            $check->delete();
        }
    }
}

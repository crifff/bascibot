<?php

class CheckedController extends Controller
{
    /** @var  Bot */
    public $bot;

    protected function beforeAction($action)
    {
        $server = $_GET['server'];
        $channel = $_GET['channel'];
        $this->bot = Bot::model()->findByAttributes(array('server' => $server, 'channel' => $channel));
        return (bool)$this->bot;
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = new Program('search');
        $model->unsetAttributes(); // clear any default values
        //        $model->botId = $this->bot->id;
        if (isset($_GET['Program'])) {
            $model->attributes = $_GET['Program'];
        }

        if (isset($_GET['json'])) {
            header('Content-type: application/json');
            echo CJSON::encode($model->checkedSearch($this->bot->id)->getData());
            foreach (Yii::app()->log->routes as $route) {
                if ($route instanceof CWebLogRoute) {
                    $route->enabled = false; // disable any weblogroutes
                }
            }
            Yii::app()->end();
        } else {
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
    }

    public function actionNow()
    {
        $model = new Program('search');
        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['json'])) {
            header('Content-type: application/json');
            echo CJSON::encode($model->getNowArray($this->bot->id));
            foreach (Yii::app()->log->routes as $route) {
                if ($route instanceof CWebLogRoute) {
                    $route->enabled = false; // disable any weblogroutes
                }
            }
            Yii::app()->end();
        } else {
            $this->render(
                'admin',
                array(
                    'model' => $model,
                )
            );
        }

    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Program the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Program::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}

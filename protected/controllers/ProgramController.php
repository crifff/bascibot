<?php

class ProgramController extends Controller
{
	/**
	 * Lists all models.
	 */
	public function actionIndex()
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
			)
		);
	}

	/**
	 * @param int $titleId
	 * @param int $channelId
	 */
	public function actionCheck($titleId, $channelId)
	{
		$check = Check::model()->findByAttributes(array('titleId' => $titleId, 'channelId' => $channelId));
		if (!$check) {
			$check = new Check();
		}
		$check->titleId = $titleId;
		$check->channelId = $channelId;
		$check->save();
	}

	/**
	 * @param int $titleId
	 * @param int $channelId
	 */
	public function actionUnCheck($titleId, $channelId)
	{
		$check = Check::model()->findByAttributes(array('titleId' => $titleId, 'channelId' => $channelId));
		if ($check) {
			$check->delete();
		}
	}
}

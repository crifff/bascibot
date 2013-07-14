<?php
class UpdateCommand extends CConsoleCommand
{
	public function actionIndex()
	{
		$programs = $this->getProgram();
		foreach ($programs->items as $program)
		{
			$this->setChannel($program);
			$this->setTitle($program);
			$this->setProgram($program);
		}
	}

	private function setChannel($program)
	{
		$channel = Channel::model()->findByPk($program->ChID);
		if (! $channel)
			$channel = new Channel();
		$channel->id = $program->ChID;
		$channel->name = $program->ChName;
		$channel->url = $program->ChURL;
		$channel->groupId = $program->ChGID;
		echo $channel->name . "\n";
		$channel->save();
	}

	private function setProgram($data)
	{
		$program = Program::model()->findByPk($data->PID);
		if (! $program)
			$program = new Program();
		$program->id = $data->PID;
		$program->channelId = $data->ChID;
		$program->titleId = $data->TID;
		$program->subTitle = $data->SubTitle;
		$program->allDay = $data->AllDay;
		$program->deleted = $data->Deleted;
		$program->flag = $data->Flag;
		$program->warn = $data->Warn;
		$program->startTime = date('Y-m-d H:i:s', $data->StTime);
		$program->endTime = date('Y-m-d H:i:s', $data->EdTime);
		$program->lastUpdate = date('Y-m-d H:i:s', $data->LastUpdate);
		$program->revision = $data->Revision;
		$program->save();
	}

	private function setTitle($data)
	{
		$title = Title::model()->findByPk($data->ChID);
		if (! $title)
			$title = new Title();
		$title->id = $data->ChID;
		$title->title = $data->Title;
		$title->shortTitle = $data->ShortTitle;
		$title->urls = $data->Urls;
		$title->category = $data->Cat;
		$title->save();
	}

	private function getProgram()
	{
		$data = file_get_contents(Yii::app()->basePath . '/data/json');
		$data = json_decode($data);
		return $data;
	}
}
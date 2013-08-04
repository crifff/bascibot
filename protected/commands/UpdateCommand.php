<?php
class UpdateCommand extends CConsoleCommand
{
	public function actionIndex($days = 7)
	{
		$programs = $this->getProgram($days);
		foreach ($programs->items as $program) {
			$this->setChannel($program);
			$this->setTitle($program);
			$this->setProgram($program);
		}
	}

	private function setChannel($program)
	{
		$channel = Channel::model()->findByPk($program->ChID);
		if (!$channel) {
			$channel = new Channel();
		}
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
		if (!$program) {
			$program = new Program();
		}
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
		$title = Title::model()->findByPk($data->TID);
		if (!$title) {
			$title = new Title();
		}
		$title->id = $data->TID;
		$title->title = $data->Title;
		$title->shortTitle = $data->ShortTitle;
		$title->urls = $data->Urls;
		$title->category = $data->Cat;
		$title->save();
	}

	private function getProgram($days)
	{
		$start = time();
		$end = $start + $days * 24 * 60 * 60;
		$url = sprintf(
			"http://cal.syoboi.jp/rss2.php?alt=json&filter=0&start=%d&end=%d",
			date('YmdHi', $start),
			date('YmdHi', $end)
		);
		$data = file_get_contents($url);
		$data = json_decode($data);
		return $data;
	}
}
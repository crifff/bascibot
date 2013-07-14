<?php

class m130714_114852_create_program_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('program', array(
			'id' => 'pk',
			'channelId' => 'int NOT NULL',
			'titleId' => 'int NOT NULL',
			'startTime' => 'DATETIME NOT NULL',
			'endTime' => 'DATETIME NOT NULL',
			'lastUpdate' => 'DATETIME NOT NULL',
			'subTitle' => 'text NOT NULL',
			'flag' => 'int NOT NULL',
			'deleted' => 'int NOT NULL',
			'warn' => 'int NOT NULL',
			'revision' => 'int NOT NULL',
			'allDay' => 'int NOT NULL',
		));
	}

	public function down()
	{
		$this->dropTable('program');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
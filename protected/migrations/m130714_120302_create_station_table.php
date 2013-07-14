<?php

class m130714_120302_create_station_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('station', array(
			'id' => 'pk',
			'name' => 'text NOT NULL',
			'url' => 'text NOT NULL',
		));
	}

	public function down()
	{
		$this->dropTable('station');
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
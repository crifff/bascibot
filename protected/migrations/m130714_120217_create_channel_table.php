<?php

class m130714_120217_create_channel_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('channel', array(
			'id' => 'pk',
			'groupId' => 'int',
			'name' => 'text NOT NULL',
		));
	}

	public function down()
	{
		$this->dropTable('channel');
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
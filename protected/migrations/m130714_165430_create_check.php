<?php

class m130714_165430_create_check extends CDbMigration
{
	public function up()
	{
		$this->createTable('check', array(
			'id' => 'pk',
			'channelId' => 'int NOT NULL',
			'titleId' => 'int NOT NULL',
		));
		$this->addForeignKey('fk_check_titleId', 'check', 'titleId', 'title', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('fk_check_channelId', 'check', 'channelId', 'channel', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		$this->dropTable('check');
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
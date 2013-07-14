<?php

class m130714_120536_create_Title_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('title', array(
			'id' => 'pk',
			'title' => 'text NOT NULL',
			'shortTitle' => 'text',
			'category' => 'int',
			'urls' => 'text',
		));
	}

	public function down()
	{
		$this->dropTable('title');

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
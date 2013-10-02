<?php

class m131002_152327_alter_program extends CDbMigration
{
	public function up()
	{
    $this->alterColumn('program', 'subTitle', 'TEXT DEFAULT NULL');
	}

	public function down()
	{
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

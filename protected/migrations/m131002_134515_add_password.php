<?php

class m131002_134515_add_password extends CDbMigration
{
	public function up()
	{
    $this->addColumn('bot', 'password', 'varchar(32)');
	}

	public function down()
	{
    $this->dropColumn('bot', 'password');
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

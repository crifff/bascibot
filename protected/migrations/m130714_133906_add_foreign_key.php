<?php

class m130714_133906_add_foreign_key extends CDbMigration
{
	public function up()
	{
		$this->addForeignKey('fk_program_titleId', 'program', 'titleId', 'title', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('fk_program_channelId', 'program', 'channelId', 'channel', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		$this->dropForeignKey('fk_program_titleId', 'program');
		$this->dropForeignKey('fk_program_channelId', 'program');
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
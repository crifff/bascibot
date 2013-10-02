<?php

class m130930_152430_add_column_checked extends CDbMigration
{
	public function up()
	{
        $this->addColumn('check', 'botId', 'int NOT NULL');
        $this->addForeignKey('fk_check_botId', 'check', 'botId', 'bot', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
        $this->dropForeignKey('fk_bot_botId', 'check');
        $this->dropColumn('check', 'botId');
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
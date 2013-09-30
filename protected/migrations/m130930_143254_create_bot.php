<?php

class m130930_143254_create_bot extends CDbMigration
{
    public function up()
    {
        $this->createTable(
            'bot',
            array(
                'id' => 'pk',
                'nickName' => 'varchar(16) NOT NULL',
                'realName' => 'varchar(16) NOT NULL',
                'server' => 'varchar(256) NOT NULL',
                'port' => 'int NOT NULL',
                'channel' => 'varchar(128) NOT NULL',
            )
        );
        $this->createIndex('channel_unique', 'bot', 'channel', true);
    }

    public function down()
    {
        $this->dropTable('bot');
        return false;
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
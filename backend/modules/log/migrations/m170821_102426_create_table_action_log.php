<?php
use wocenter\console\Migration;

class m170821_102426_create_table_action_log extends Migration
{

    public function safeUp()
    {
        $this->setForeignKeyCheck();

        $this->createTable('{{%action_log}}', [
            'id' => $this->primaryKey()->unsigned()->comment('主键'),
            'action_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0)->comment('行为id'),
            'user_id' => $this->integer(11)->unsigned()->notNull()->comment('执行用户'),
            'action_ip' => $this->bigInteger(20)->notNull()->comment('操作IP'),
            'action_location' => $this->char(50)->notNull()->comment('操作地理位置'),
            'model' => $this->string(50)->notNull()->defaultValue('')->comment('触发行为的表'),
            'record_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('触发行为的数据id'),
            'created_at' => $this->integer()->unsigned()->notNull()->comment('执行行为的时间'),
            'created_type' => $this->boolean()->unsigned()->notNull()->defaultValue(0)->comment('创建类型 0-系统 1-用户 2-公共'),
            'request_url' => $this->string(512)->notNull()->comment('请求地址'),
        ], $this->tableOptions . $this->buildTableComment('行为日志表'));

        $this->createIndex('idx-action_log-created_type', '{{%action_log}}', 'created_type');
        $this->createIndex('idx-action_log-created_at', '{{%action_log}}', 'created_at');

        $this->addForeignKey('fk-action_log-action_id', '{{%action_log}}', 'action_id', '{{%action}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-action_log-user_id', '{{%action_log}}', 'user_id', '{{%user}}', 'id', 'CASCADE');

        $this->setForeignKeyCheck(true);
    }

    public function safeDown()
    {
        $this->dropTable('{{%action_log}}');
    }

}

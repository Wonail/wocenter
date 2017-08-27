<?php
use wocenter\console\Migration;

class m170822_060038_create_table_invite_log extends Migration
{
    
    public function safeUp()
    {
        $this->setForeignKeyCheck();
        
        $this->createTable('{{%invite_log}}', [
            'id' => $this->primaryKey(11)->unsigned()->comment('ID'),
            'uid' => $this->integer(11)->unsigned()->notNull()->comment('注册者'),
            'inviter_id' => $this->integer(11)->unsigned()->notNull()->comment('邀请人id'),
            'invite_type_id' => $this->integer(11)->unsigned()->notNull()->comment('邀请码类型id'),
            'remark' => $this->string(200)->notNull()->comment('备注'),
            'created_at' => $this->integer()->unsigned()->notNull()->unsigned()->comment('注册时间'),
        ], $this->tableOptions . $this->buildTableComment('邀请注册成功记录表'));
        
        $this->addForeignKey('fk-invite_log-uid', '{{%invite_log}}', 'uid', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-invite_log-inviter_id', '{{%invite_log}}', 'inviter_id', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-invite_log-invite_type_id', '{{%invite_log}}', 'invite_type_id', '{{%invite_type}}', 'id', 'CASCADE');
        
        $this->setForeignKeyCheck(true);
    }
    
    public function safeDown()
    {
        $this->dropTable('{{%invite_log}}');
    }
    
}

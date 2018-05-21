<?php

namespace board\migrations;

use yii\db\Migration;

/**
 * Class m180521_094011_board_bans
 */
class m180521_094011_board_bans extends Migration
{

    public $tableName = '{{%board_bans}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = '';

        if ($this->db->driverName === 'mysql')
        {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(10)->unsigned(),
            'created' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'username' => $this->string(),
            'ip' => $this->string(),
            'email' => $this->string(),
            'message' => $this->string(),
            'expire' => $this->integer()->unsigned(),
            'ban_creator' => $this->integer(11)
        ], $tableOptions);

        $this->createIndex('board_bans_username_idx', $this->tableName, ['username'], false);

        $this->createIndex('board_bans_email_idx', $this->tableName, ['email'], false);

        $this->addForeignKey(
            'board_bans_ban_creator_fk', 
            $this->tableName, 
            'ban_creator',
            '{{%user}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('board_bans_username_idx', $this->tableName);

        $this->dropIndex('board_bans_email_idx', $this->tableName);

        $this->dropForeignKey('board_bans_ban_creator_fk', $this->tableName);

        $this->dropTable($this->tableName);
    }

}

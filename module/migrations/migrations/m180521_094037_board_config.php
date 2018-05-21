<?php

namespace board\migrations;

use yii\db\Migration;

/**
 * Class m180521_094037_board_config
 */
class m180521_094037_board_config extends Migration
{

    public $tableName = '{{%board_config}}';

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
            'conf_name' => $this->string()->notNull(),
            'conf_value' => $this->text()
        ], $tableOptions);

        $this->addPrimaryKey(null, $this->tableName, ['conf_name']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }

}

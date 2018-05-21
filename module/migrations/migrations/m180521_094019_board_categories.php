<?php

namespace board\migrations;

use yii\db\Migration;

/**
 * Class m180521_094019_board_categories
 */
class m180521_094019_board_categories extends Migration
{

    public $tableName = '{{%board_categories}}';

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
            'cat_name' => $this->string()->notNull()->defaultValue('New Category'),
            'disp_position' => $this->integer(10)->notNull()->defaultValue(0)
        ], $tableOptions);

        $this->createIndex('board_categories_disp_position_idx', $this->tableName, ['disp_position'], false);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('board_categories_disp_position_idx', $this->tableName);

        $this->dropTable($this->tableName);
    }

}
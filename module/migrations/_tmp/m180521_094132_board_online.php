<?php

use yii\db\Migration;

/**
 * Class m180521_094132_board_online
 */
class m180521_094132_board_online extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180521_094132_board_online cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180521_094132_board_online cannot be reverted.\n";

        return false;
    }
    */
}

<?php

namespace board\migrations;

use yii\db\Migration;

/**
 * Class m180508_193431_board_user_drop
 */
class m180508_193431_board_user_drop extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    	$this->dropTable('board_users');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180508_193431_board_user_drop cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180508_193431_board_user_drop cannot be reverted.\n";

        return false;
    }
    */
}

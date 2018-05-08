<?php

namespace board\migrations;

use yii\db\Migration;
use Yii;

/**
 * Class m180508_192714_board_categories_clear
 */
class m180508_192714_board_categories_clear extends Migration
{
	
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    	Yii::$app->db->createCommand('TRUNCATE TABLE `board_categories`')->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }

}
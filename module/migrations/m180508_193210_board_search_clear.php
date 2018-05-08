<?php

namespace board\migrations;

use yii\db\Migration;
use Yii;

/**
 * Class m180508_193210_board_search_clear
 */
class m180508_193210_board_search_clear extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    	Yii::$app->db->createCommand('TRUNCATE TABLE `board_search_matches`')->execute();

    	Yii::$app->db->createCommand('TRUNCATE TABLE `board_search_words`')->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }

}
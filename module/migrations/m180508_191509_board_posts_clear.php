<?php

namespace board\migrations;

use yii\db\Migration;
use Yii;

/**
 * Class m180508_191509_board_posts_clear
 */
class m180508_191509_board_posts_clear extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    	Yii::$app->db->createCommand('TRUNCATE TABLE `board_posts`')->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }

}
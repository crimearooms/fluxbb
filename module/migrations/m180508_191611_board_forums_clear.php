<?php

namespace board\migrations;

use yii\db\Migration;
use Yii;

/**
 * Class m180508_191611_board_forums_clear
 */
class m180508_191611_board_forums_clear extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		Yii::$app->db->createCommand('TRUNCATE TABLE `board_forums`')->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }

}
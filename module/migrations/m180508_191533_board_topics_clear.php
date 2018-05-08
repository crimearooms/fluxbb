<?php

namespace board\migrations;

use yii\db\Migration;
use Yii;

/**
 * Class m180508_191533_board_topics_clear
 */
class m180508_191533_board_topics_clear extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    	Yii::$app->db->createCommand('TRUNCATE TABLE `board_topics`')->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
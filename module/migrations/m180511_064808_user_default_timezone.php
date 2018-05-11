<?php

namespace board\migrations;

use yii\db\Migration;

/**
 * Class m180511_064808_user_default_timezone
 */
class m180511_064808_user_default_timezone extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    	$this->alterColumn('{{%user}}', 'timezone', $this->float()->notNull()->defaultValue(4));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%user}}', 'timezone', $this->float()->notNull()->defaultValue(0));
    }

}
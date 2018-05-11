<?php

namespace board\migrations;

use yii\db\Migration;

/**
 * Class m180511_064629_user_default_group_id
 */
class m180511_064629_user_default_group_id extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    	$this->alterColumn('{{%user}}', 'group_id', $this->integer(10)->unsigned()->notNull()->defaultValue(4));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%user}}', 'group_id', $this->integer(10)->unsigned()->notNull()->defaultValue(3));
    }

}
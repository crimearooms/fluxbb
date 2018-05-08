<?php

namespace board\migrations;

use yii\db\Migration;
use common\models\User;
use Exception;
use Yii;

/**
 * Class m180508_180556_user_add_guest_user
 */
class m180508_180556_user_add_guest_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    	$time = time();

    	Yii::$app->db->createCommand()
    		->insert('user', [
    			'group_id' => 3,
    			'username' => 'Guest',
    			'auth_key' => '',
    			'password_hash' => '',
    			'email' => 'guest@example.com',
    			'created_at' => $time,
    			'updated_at' => $time,
    			'timezone' => 4
    		])
    		->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    	$model = User::find()->where(['username' => 'Guest'])->one();

    	if (!$model)
    	{
    		throw new Exception('Guest user not found.');
    	}

    	if (!$model->delete())
    	{
    		throw new Exception('Guest user not deleted.');
    	}
    }

}
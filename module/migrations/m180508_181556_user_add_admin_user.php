<?php

namespace board\migrations;

use yii\db\Migration;
use Yii;
use Exception;
use common\models\User;

/**
 * Class m180508_181556_user_add_admin_user
 */
class m180508_181556_user_add_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    	$username = isset(Yii::$app->params['adminUsername']) ? Yii::$app->params['adminUsername'] : 'admin';

    	$model = User::find()->where(['username' => $username])->one();

    	if (!$model)
    	{
	    	$model = new User;

	    	$model->email = Yii::$app->params['adminEmail'];

	    	$model->setPassword(isset(Yii::$app->params['adminDefaultPassword']) ? Yii::$app->params['adminDefaultPassword'] : '12345');

			$model->generateAuthKey();
    	}

    	$model->group_id = 1;

    	$model->username = $username;

    	$model->timezone = 4;

    	$model->num_posts = 0;

    	$model->last_visit = '1525794455';

    	$model->last_post = '1525794455';

    	$model->registration_ip = '127.0.0.1';

    	if (!$model->save(false))
    	{
    		throw new Exception('Admin user not saved.');
    	}
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    	$username = isset(Yii::$app->params['adminUsername']) ? Yii::$app->params['adminUsername'] : 'admin';

    	$model = User::find()->where(['username' => $username])->one();

    	if (!$model)
    	{
    		throw new Exception('Admin user not found.');
    	}

    	if (!$model->delete())
    	{
    		throw new Exception('Admin user not deleted.');
    	}
    }

}
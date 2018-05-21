<?php

namespace board\components;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression as DbExpression;
use board\models\BoardOnline;

class BoardUserBehavior extends \yii\base\Behavior
{

	public function events()
	{
		return [
			ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert'
		];
	}

	public function beforeInsert($event)
	{
		$event->sender->last_visit = new DbExpression('UNIX_TIMESTAMP(NOW())');
	}

	public function getBoardOnline()
	{
		return $this->owner->hasOne(BoardOnline::className(), ['user_id' => 'id']);
	}

}
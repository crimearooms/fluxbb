<?php

namespace board\components;

use yii\web\User as WebUser;

class BoardWebUserBehavior extends \yii\base\Behavior
{

	public function events()
	{
		return [
			WebUser::EVENT_BEFORE_LOGOUT => 'beforeLogout'
		];
	}

	public function beforeLogout($event)
	{
		$user = $event->sender->identity;

		if ($user->boardOnline)
		{
			$user->last_visit= $user->boardOnline->logged;

			$user->save(false, ['last_visit']);
		}
	}

}
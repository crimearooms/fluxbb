<?php

Yii::setAlias('@board', dirname(__DIR__));

return [
	'bootstrap' => [
		'board'
	],
	'components' => [
		'board' => [
			'class' => 'board\components\BoardComponent'
		],
		'user' => [
			'as board' => [
				'class' => 'board\components\BoardWebUserBehavior'
			]
		]
	],
	'container' => [
		'definitions' => [
			'common\models\User' => [
				'as board' => [
					'class' => 'board\components\BoardUserBehavior'
				]
			]
		]
	]
];
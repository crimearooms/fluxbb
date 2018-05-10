<?php

Yii::setAlias('@board', dirname(__DIR__));

return [
	'bootstrap' => [
		'board'
	],
	'components' => [
		'board' => [
			'class' => 'board\components\BoardComponent'
		]
	]
];
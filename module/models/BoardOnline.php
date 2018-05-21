<?php

namespace board\models;

class BoardOnline extends \yii\db\ActiveRecord
{

	public static function tableName()
	{
		return '{{%board_online}}';
	}

}
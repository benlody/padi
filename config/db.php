<?php

if (YII_ENV_DEV){

	return [
		'class' => 'yii\db\Connection',
		'dsn' => 'mysql:host=localhost;dbname=padi_test',
		'username' => 'root',
		'password' => 'admin',
		'charset' => 'utf8',
	];

} else {

	return [
		'class' => 'yii\db\Connection',
		'dsn' => 'mysql:host=localhost;dbname=padi',
		'username' => 'root',
		'password' => 'admin',
		'charset' => 'utf8',
	];
}


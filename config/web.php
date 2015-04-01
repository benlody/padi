<?php

$params = require(__DIR__ . '/params.php');

$supportedLangs = array('zh-TW', 'zh-CN', 'zh', 'en-US', 'en', 'en-au');
$languages = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
foreach($languages as $lang)
{
	$language = 'en';
    if(in_array($lang, $supportedLangs))
    {
        $language  = $lang;
        break;
    }
}

$config = [
	'id' => 'basic',
	'basePath' => dirname(__DIR__),
	'language' => $language,
//	'language' => 'en-US',
	'bootstrap' => ['log'],
	'components' => [
		'request' => [
			// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			'cookieValidationKey' => 'Amv7zLYvKRaYltIYzlMQCRuDaqJpQPzZ',
		],
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'user' => [
			'identityClass' => 'app\models\User',
			'enableAutoLogin' => true,
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'mailer' => [
			'class' => 'yii\swiftmailer\Mailer',
			// send all mails to a file by default. You have to set
			// 'useFileTransport' to false and configure a transport
			// for the mailer to send real emails.
			'useFileTransport' => false,
			'viewPath' => '@app/mail',
			'transport' => [
				'class' => 'Swift_SmtpTransport',
				'host' => 'smtp.gmail.com',
				'username' => 'notify@lang-win.com.tw',
				'password' => '23314526',
				'port' => '465',
				'encryption' => 'ssl',
			],
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'db' => require(__DIR__ . '/db.php'),
		'i18n' => [
			'translations' => [
				'*' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@app/messages',
					'sourceLanguage' => 'en-US',
					'fileMap' => [
						'app' => 'app.php',
						'app/error' => 'error.php',
					],
				],
			],
		],
		'formatter' => [
			'dateFormat' => 'MM/d/Y',
		],
	],
	'params' => $params,
];

if (YII_ENV_DEV) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][] = 'debug';
	$config['modules']['debug'] = 'yii\debug\Module';

	$config['bootstrap'][] = 'gii';
	$config['modules']['gii'] = 'yii\gii\Module';
//	$config['modules']['gii']['allowedIPs'] = ['127.0.0.1', '192.168.0.*'];
}

return $config;

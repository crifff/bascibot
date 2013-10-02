<?php

return CMap::mergeArray(
	require(dirname(__FILE__) . '/database.php'),
	array(
		'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
		'name' => 'bascibot {\'<\'}',
		'preload' => array('log'),
		'import' => array(
			'application.models.*',
			'application.components.*',
		),
		'modules' => array(
			'gii' => array(
				'class' => 'system.gii.GiiModule',
				'password' => 'hoge',
			),
		),
		'components' => array(
			'user' => array(
				'allowAutoLogin' => true,
			),
			'urlManager' => array(
				'urlFormat' => 'path',
				'rules' => array(
					'<server:\w+>/<channel:\w+>/<controller:\w+>/' => '<controller>/index',
					'<server:\w+>/<channel:\w+>/<controller:\w+>/<id:\d+>' => '<controller>/view',
					'<server:\w+>/<channel:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
					'<server:\w+>/<channel:\w+>/<controller:\w+>/<action:\w+>' => '<controller>/<action>',
				),
				'showScriptName' => false,
			),
			'errorHandler' => array(
				'errorAction' => 'site/error',
			),
			'log' => array(
				'class' => 'CLogRouter',
				'routes' => array(
					array(
						'class' => 'CFileLogRoute',
						'levels' => 'error, warning',
					),
				),
			),
			'widgetFactory' => array(
				'widgets' => array(
					'CLinkPager' => array(
						'maxButtonCount' => 5,
						'cssFile' => false,
					),
					'CGridView' => array(
						'cssFile' => false,
					),
					'CJuiDatePicker' => array(
						'language' => 'ja',
					),
				),
			),
		),
		'params' => array(
			'adminEmail' => 'webmaster@example.com',
		),
	)
);

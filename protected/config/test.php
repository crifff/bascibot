<?php

return CMap::mergeArray(
	require(dirname(__FILE__) . '/main.php'),
	array(
		'components' => array(
			'fixture' => array(
				'class' => 'system.test.CDbFixtureManager',
			),
			'log' => array(
				'class' => 'CLogRouter',
				'routes' => array(
					array(
						'class' => 'CWebLogRoute',
					),
				),
			)
		),
	)
);

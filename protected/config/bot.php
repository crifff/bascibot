<?php

return array(
	'connections' => array(
		array(
			'host' => 'localhost',
			'port' => 6667,
			'username' => 'bascibot',
			'realname' => 'bascibot',
			'nick' => 'bascibot',
		)
	),

	'processor' => 'async',
	'processor.options' => array('usec' => 200000),
	'timezone' => 'Asia/Tokyo',

	'plugins' => array(
		'AutoJoin',
		'Pong',
		'Ping',
		'Quit',
		'Url',
		'Anime',
		'Joke',
	),

	'plugins.autoload' => true,

	'ui.enabled' => true,

	'command.prefix' => '!',
	// 'autojoin.channels' => array('#channel1', '#channel2'),
	// 'autojoin.channels' => array(
	//                            'host1' => '#channel1,#channel2',
	//                            'host2' => array('#channel3', '#channel4')
	//                        ),
	'autojoin.channels' => '#test',
	'Anime.api' => 'http://localhost/bascibot/',

	// This is the amount of time in seconds that the Ping plugin will wait
	// to receive an event from the server before it initiates a self-ping
	// 'ping.event' => 300, // 5 minutes
	// This is the amount of time in seconds that the Ping plugin will wait
	// following a self-ping attempt before it assumes that a response will
	// never be received and terminates the connection
	// 'ping.ping' => 10, // 10 seconds
);

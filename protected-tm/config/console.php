<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Consola TM',

	// preloading 'log' component
	'preload'=>array('log'),

	'import'=>array(
        'application.components.*',
        'application.models.*',
    ),

	// application components
	'components'=>array(
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=telemede_tm',
			'emulatePrepare' => true,
			'username' => 'telemede_tm',
			'password' => 'kk_#=2B8I-+V',
			'charset' => 'utf8',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
					'logFile' => 'console.log',
				),
			),
		),
	),
);
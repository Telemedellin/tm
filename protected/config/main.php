<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Telemedellín',
	'defaultController'=>'telemedellin',
	'language'=>'es',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.vendors.bcrypt.*',
		'application.vendors.UploadHandler.*', 
		'ext.image.Image', 
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'asdf1234*',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),
	'controllerMap'=>array(
	    'YiiFeedWidget' => 'ext.yii-feed-widget.YiiFeedWidgetController', 
	    'visor' 		=> 'ext.editMe.widgets.ExtCkfinderController',
	    'controlGaleria'=> 'ext.galleryManager.GalleryController'
	),
	// application components
	'components'=>array(
		'session' => array(
	        'autoStart'=>true,
	    ),
		'user'=>array(
			// enable cookie-based authentication
			//'allowAutoLogin'=>true,
			'loginUrl'=>array('administrador/ingresar'),
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(
				'gii'=>'gii',
	            'gii/<controller:\w+>'=>'gii/<controller>',
	            'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
	            'administrador'=>'administrador/admin',
	            'administrador/ingresar'=>'administrador/admin/ingresar',
	            'administrador/registro'=>'administrador/admin/registro',
	            'administrador/salir'=>'administrador/admin/salir',
	            'administrador/recuperar-contrasena'=>'administrador/admin/recuperarcontrasena',
	            'administrador/<controller:\w+>'=>'administrador/<controller>',
	            'administrador/<controller:\w+>/<action:\w+>/<id:\d+>'=>'administrador/<controller>/<action>',
	            'administrador/<controller:\w+>/<action:\w+>/<id:\d+>/<tipo_pagina_id:\d+>'=>'administrador/<controller>/<action>',
	            'administrador/<controller:\w+>/<action:\w+>'=>'administrador/<controller>/<action>',
	            array(
				    'class' => 'application.components.TmUrlRule',
				    'connectionID' => 'db',
			  	),
			  	'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		/*'db'=>array(
			'connectionString' => 'mysql:host=noticias.telemedellin.tv;dbname=telemede_telemedellin',
			'emulatePrepare' => true,
			'username' => 'telemede_telemed',
			'password' => ';0?LegNmMi)O',
			'charset' => 'utf8',
		),
		*/
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=med2018_tm',
			'emulatePrepare' => true,
			'username' => 'med2018_tm',
			'password' => 'asdf1234*',
			'charset' => 'utf8',
		),
		'twitter' => array(
            'class' => 'ext.yiitwitteroauth.YiiTwitter',
            'consumer_key' => 'lvX5ZuwYkNNFwaYaLz0Rw',
            'consumer_secret' => 'tkEfo98Xcpg0rYphooAetOSVjBcYEXhM4pKTGh1Bw',
            'callback' => '',
        ),
        'image'=>array(
            'class'=>'ext.image.CImageComponent',
            // GD or ImageMagick
            'driver'=>'GD',
            // ImageMagick setup path
            //'params'=>array('directory'=>'D:/Program Files/ImageMagick-6.4.8-Q16'),
        ),
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'telemedellin/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				array(
                    'class' => 'CFileLogRoute',
                    'categories' => '404',
                    'logFile' => '404'
                ), 
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				/**/
			),
		),
		'cache'=>array(
            'class'=>'system.caching.CFileCache',
        ),
	),
	
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'victor.arias@telemedellin.tv',
	),
);
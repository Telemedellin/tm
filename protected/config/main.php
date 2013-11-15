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
		'application.vendors.UploadHandler.*'
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
	    'buscar' => 'ext.tm-buscador.TmBuscadorController'
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
	            'administrador/<controller:\w+>/<action:\w+>'=>'administrador/<controller>/<action>',
				array(
				    'class' => 'application.components.TmUrlRule',
				    'connectionID' => 'db',
			  	),
			  	'mapa-del-sitio' => 'telemedellin/mapadelsitio', 
			  	'sitemap.xml' => 'telemedellin/mapadelsitio', 
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'db'=>array(
			'connectionString' => 'mysql:host=telemedellin.tv;dbname=telemede_tm',
			'emulatePrepare' => true,
			'username' => 'telemede_tm',
			'password' => 'kk_#=2B8I-+V',
			'charset' => 'utf8',
		),
		'twitter' => array(
            'class' => 'ext.yiitwitteroauth.YiiTwitter',
            'consumer_key' => 'lvX5ZuwYkNNFwaYaLz0Rw',
            'consumer_secret' => 'tkEfo98Xcpg0rYphooAetOSVjBcYEXhM4pKTGh1Bw',
            'callback' => '',
        ),
			
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
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'cache'=>array(
            'class'=>'system.caching.CDummyCache',
        ),
	),
	
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'victor.arias@telemedellin.tv',
	),
);
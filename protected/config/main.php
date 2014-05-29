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
	'layout' => 'administrador', 

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.vendors.bcrypt.*',
		'application.vendors.UploadHandler.*', 
		'ext.image.Image', 
		'application.modules.cruge.components.*',
		'application.modules.cruge.extensions.crugemailer.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'asdf1234*',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'cruge'=>array(
			'tableprefix'=>'cruge_',
			// para que utilice a protected.modules.cruge.models.auth.CrugeAuthDefault.php
			// en vez de 'default' pon 'authdemo' para que utilice el demo de autenticacion alterna
			// para saber mas lee documentacion de la clase modules/cruge/models/auth/AlternateAuthDemo.php
			'availableAuthMethods'=>array('default'),
			'availableAuthModes'=>array('username','email'),
            // url base para los links de activacion de cuenta de usuario
			'baseUrl'=>'http://concursomedellin2018.com/tm/',
			 // NO OLVIDES PONER EN FALSE TRAS INSTALAR
			 'debug'=>false,
			 'rbacSetupEnabled'=>true,
			 'allowUserAlways'=>false,
			// MIENTRAS INSTALAS..PONLO EN: false
			// lee mas abajo respecto a 'Encriptando las claves'
			'useEncryptedPassword' => true,
			// Algoritmo de la función hash que deseas usar
			// Los valores admitidos están en: http://www.php.net/manual/en/function.hash-algos.php
			'hash' => 'md5',
			// Estos tres atributos controlan la redirección del usuario. Solo serán son usados si no
			// hay un filtro de sesion definido (el componente MiSesionCruge), es mejor usar un filtro.
			//  lee en la wiki acerca de:
            //   "CONTROL AVANZADO DE SESIONES Y EVENTOS DE AUTENTICACION Y SESION"
            //
			// ejemplo:
			//		'afterLoginUrl'=>array('/site/welcome'),  ( !!! no olvidar el slash inicial / )
			//		'afterLogoutUrl'=>array('/site/page','view'=>'about'),
			//
			'afterLoginUrl'=>array('/administrador'),
			'afterLogoutUrl'=>array('/cruge/ui/login'),
			'afterSessionExpiredUrl'=>array('/cruge/ui/login'),
			// manejo del layout con cruge.
			//
			'loginLayout'=>'//layouts/administrador',
			'registrationLayout'=>'//layouts/administrador',
			'activateAccountLayout'=>'//layouts/administrador',
			'editProfileLayout'=>'//layouts/administrador',
			'resetPasswordLayout'=>'//layouts/administrador',
			// en la siguiente puedes especificar el valor "ui" o "column2" para que use el layout
			// de fabrica, es basico pero funcional.  si pones otro valor considera que cruge
			// requerirá de un portlet para desplegar un menu con las opciones de administrador.
			//
			'generalUserManagementLayout'=>'ui',
			// permite indicar un array con los nombres de campos personalizados, 
			// incluyendo username y/o email para personalizar la respuesta de una consulta a: 
			// $usuario->getUserDescription(); 
			'userDescriptionFieldsArray'=>array('email'), 
		),
		'administrador' => array(), 
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
		/*'user'=>array(
			// enable cookie-based authentication
			//'allowAutoLogin'=>true,
			'loginUrl'=>array('administrador/ingresar'),
		),/**/
		'user'=>array(
			'allowAutoLogin' => true,
			'loginUrl' 		 => array('/cruge/ui/login'),
			'class' 		 => 'application.modules.cruge.components.CrugeWebUser',
		),
		'authManager' => array(
			'class' => 'application.components.MyCrugeAuthManager',
		),
		'crugemailer'=>array(
			'class' 		=> 'application.modules.cruge.components.CrugeMailer',
			'mailfrom' 		=> 'no-reply@telemedellin.tv',
			'subjectprefix' => 'TM - ',
			'debug' 		=> true,
		),
		'format' => array(
			'datetimeFormat'=>"d M, Y h:m:s a",
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
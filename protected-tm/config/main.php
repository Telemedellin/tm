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
	'timeZone' => 'America/Bogota',
	// preloading 'log' component
	'preload'=>array('log'),
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.administrador.models.*',
		'application.modules.cruge.components.*',
		'application.modules.cruge.extensions.crugemailer.*',
		'application.modules.usuario.models.*',
		'application.modules.usuario.components.*',
		'application.extensions.crugeconnector.*',
		'application.extensions.yiifilemanager.*',
		'application.extensions.yiifilemanagerfilepicker.*',
		'application.extensions.image.Image', 
		'application.vendors.bcrypt.*',
		'application.vendors.UploadHandler.*', 
	),
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'asdf1234*',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),/**/
		'cruge'=>array(
			'tableprefix'=>'cruge_',
			// para que utilice a protected.modules.cruge.models.auth.CrugeAuthDefault.php
			// en vez de 'default' pon 'authdemo' para que utilice el demo de autenticacion alterna
			// para saber mas lee documentacion de la clase modules/cruge/models/auth/AlternateAuthDemo.php
			//'availableAuthMethods'=>array('default'),
			'availableAuthMethods'=>array('authtm'),
			'availableAuthModes'=>array(/*'username',/**/'email'),
            // url base para los links de activacion de cuenta de usuario
			'baseUrl'=>'http://localhost/tm/',
			// NO OLVIDES PONER EN FALSE TRAS INSTALAR
			'debug'=>false,
			'rbacSetupEnabled'=>true,
			'allowUserAlways'=>false,
			// MIENTRAS INSTALAS..PONLO EN: false
			// lee mas abajo respecto a 'Encriptando las claves'
			'useEncryptedPassword' => true,
			// Algoritmo de la función hash que deseas usar
			// Los valores admitidos están en: http://www.php.net/manual/en/function.hash-algos.php
			'hash' => 'bcrypt',
			// Estos tres atributos controlan la redirección del usuario. Solo serán son usados si no
			// hay un filtro de sesion definido (el componente MiSesionCruge), es mejor usar un filtro.
			//  lee en la wiki acerca de:
            //   "CONTROL AVANZADO DE SESIONES Y EVENTOS DE AUTENTICACION Y SESION"
            'defaultSessionFilter'=>'application.modules.usuario.components.USesionCruge',
            //
			// ejemplo:
			//		'afterLoginUrl'=>array('/site/welcome'),  ( !!! no olvidar el slash inicial / )
			//		'afterLogoutUrl'=>array('/site/page','view'=>'about'),
			//
			'afterLoginUrl'=>array('/usuario/perfil'),
			//'afterLogoutUrl'=>array('/cruge/ui/login'),
			'afterLogoutUrl'=>array('/usuario'),
			//'afterSessionExpiredUrl'=>array('/cruge/ui/login'),
			'afterSessionExpiredUrl'=>null,/*array('/administrador/ingresar'),/**/
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
		'usuario' => array(
			'defaultController' => 'usuario',
			'components' => array(
				'crugemailer'=>array(
					'class' 		=> 'application.modules.usuario.components.MiCrugeMailer',
					'mailfrom' 		=> 'registro@telemedellin.tv',
					'subjectprefix' => '',
					'debug' 		=> true,
				),
			),
		), 
		'trivia' => array(
			'active'			=> true,
			'defaultController' => 'trivia',
			'modules' 			=> array(
				'administracion' => array(),
			),
		),
		'puntaje' => array(
			
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
			'allowAutoLogin' => true,
			//'loginUrl' 		 => array('/cruge/ui/login'),
			'loginUrl' 		 => array('/usuario'),
			'class' 		 => 'application.modules.cruge.components.CrugeWebUser',
		),
		'authManager' => array(
			'class' => 'application.components.MyCrugeAuthManager',
		),
		'format' => array(
			'datetimeFormat'=>"d M, Y h:m:s a",
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(
				/*'gii'=>'gii',
	            'gii/<controller:\w+>'=>'gii/<controller>',
	            'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',/**/
	            'administrador'=>'administrador/admin',
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
        'widgetFactory' => array(
            'widgets' => array(
                'CLinkPager' => array(
                    'htmlOptions' => array(
                        'class' => 'pagination'
                    ),
                    'header' => false,
                    'maxButtonCount' => 5,
                    'cssFile' => false,
                ),
                'CGridView' => array(
                    'htmlOptions' => array(
                        'class' => 'table-responsive'
                    ),
                    //'pagerCssClass' => 'dataTables_paginate paging_bootstrap',
                    'itemsCssClass' => 'table table-bordered table-striped dataTable',
                    'cssFile' => false,
                    //'summaryCssClass' => 'dataTables_info',
                    'summaryText' => 'Mostrando {start} a {end} de {count} filas',
                    'template' => '{items}<div class="row"><div class="col-sm-6">{summary}</div><div class="col-sm-8">{pager}</div></div>',
                ),
            ),
        ),
		'crugemailer'=>array(
			'class' 		=> 'application.components.FCrugeMailer',
			'mailfrom' 		=> 'no-responder@telemedellin.tv',
			'subjectprefix' => '',
			'debug' 		=> false,
		),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=telemedellin',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			/*'enableProfiling' => true,
        	'enableParamLogging' => true,/**/
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
        'fileman' => array(
	        'class'=>'application.extensions.yiifilemanager.YiiDiskFileManager',
	        'storage_path' => realpath(dirname(__FILE__))."/../../archivos",
		),
		'mailchimp' => array(
            // EMailChimp == API v2 integration
            'class' => 'ext.mailchimp.EMailChimp2',
            // please replace with your API key
            'apikey' => 'cc3f243402c5f9ee0a4a5f7d92a5e63f-us5',
            // you can get your `listId` from Mailchimp panel - go to List, then List Tools, and look for the List ID entry.
            'listId' => '694e8efd64',
            // (optional - default **false**) whether to use Ecommerce360 support or not
            'ecommerce360Enabled' => false,
            // (optional - default **false**) whether to enable dev mode or not
            'devMode' => false
        )
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
                /*array( 
					'class'=>'CProfileLogRoute', 
					'report'=>'summary',
			    ),/**/ 
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				/**/
			),
		),
		'cache'=>array(
            //'class'=>'system.caching.CFileCache',
            'class'=>'system.caching.CDummyCache',
        ),
	),
	'onBeginRequest' => array('ModuleUrlManager', 'collectRules'),
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'victor.arias@telemedellin.tv',
	),
);
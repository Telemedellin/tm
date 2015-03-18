<?php
class RegistroController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl',
			//array('CrugeAccessControlFilter'), 
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index', 'captcha', 'verificacion', 'facebook', 'google', 'crearclave', 'errorredes'),
				'users'=>array('?'),
			),
			array('allow',
				'actions'=>array('bienvenido'),
				'users'=>array('*'),
			),
			array('deny', 
				'actions'=>array('index', 'captcha', 'verificacion', 'facebook', 'google', 'crearclave', 'bienvenido', 'errorredes'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'foreColor' => 0xFFFFFF,
                'transparent' => true, 
                'testLimit' => 1,
            ),
        );
    }

	public function actionIndex()
	{
		
        $registroForm = new RegistroForm;
        $registroForm->scenario = 'insert';

        $this->performAjaxValidation($registroForm);

        if( isset($_POST['RegistroForm']) ){

            $registroForm->attributes = $_POST['RegistroForm'];            

            if( $registroForm->validate() && isset($_POST['RegistroForm']['terminos']) && $_POST['RegistroForm']['terminos'] == 1 ){ 

                $usuario = new Usuario('insert');

                $usuario_cruge = $usuario->registrar_usuario_cruge( $registroForm->correo, true, $registroForm->contrasena );
			
	            if( $usuario_cruge )
	            {
	                $usuario_full = $usuario->guardar_datos_usuario( $usuario_cruge, $registroForm );

	                if( $usuario_full )
	                {
	                    $this->getModule()->crugemailer->verificar_registro($usuario_cruge, $registroForm->nombres);
	                    $this->redirect( array('/usuario/registro/verificacion') );#registration-form
	                }else
	                {
						Yii::log(
			            	PHP_EOL . '<--->'.PHP_EOL .'No se guardó del todo el usuario'.PHP_EOL, 
							'warning'
						);
	                	Yii::app()->user->setFlash('error', "No se pudo completar el registro");
	                }
                }else
                {
                	Yii::app()->user->setFlash('error', "No se pudo completar el registro");
                }

            }//if($registroForm->validate())
        }//if(isset($_POST['RegistroForm']))

        $fondo_pagina = 'backgrounds/generica-interna-1.jpg';

        $this->render(
			'index', 
			array(	
				'model'         => $registroForm, 
				'fondo_pagina'  => $fondo_pagina, 
			)
		);
	}//public function actionIndex()


    public function actionVerificacion($id = '')
    {
        if( $id != '')
        {
        
        	$model = Yii::app()->user->um->loadUserByKey($id);
        	if ($model != null) {
        		
	            if ($model->state == CRUGEUSERSTATE_NOTACTIVATED) {
	    
	                Yii::app()->user->um->activateAccount($model);
	                $model->authkey = NULL;
	                if (Yii::app()->user->um->save($model)) {
	                	$mensaje = 'correo';
	                }else
	                {
	                	$mensaje = 'No';
	                }
	            }else
	            {
	            	$mensaje = 'login';
	            }
	        }else
	        {
	        	$mensaje = 'No';
	        }
	        Yii::app()->user->setFlash('bienvenido', $mensaje);
	        $this->redirect( array('/usuario/registro/bienvenido') );
        }

        $this->render('verificacion');
        
    }//public function actionVerificacion()

    public function actionFacebook()
    {
    	Yii::import('application.vendors.Facebook.*');
		include_once('facebook.php');

		$facebook = new Facebook(array(
			'appId'  => '274957429359215',
			'secret' => '2f021bff5939f3ffe097b5e29a1baec4',
		));

    	$params = array(
	        'scope' => 'public_profile, email, user_birthday, user_hometown',
	        'redirect_uri' => Yii::app()->request->hostInfo . Yii::app()->request->url,
	    );

	    $loginUrl = $facebook->getLoginUrl( $params );

	    if( $user = $facebook->getUser() ) {
	        $authkey = $this->registrar_por_red_social('facebook', $facebook->getAccessToken());
	        Yii::app()->session['key'] = $authkey;
	        $this->redirect( array('/usuario/registro/crearclave') );
	    } elseif ( $_GET['error'] ) {
	    	Yii::app()->user->setFlash('error', "No se autorizó el registro con Facebook");
	        $this->redirect( array('/usuario/registro') );
	    } else {
	        $this->redirect( $loginUrl );
	    }
    }	

    public function actionGoogle( )
    {
	    Yii::import('application.vendors.*');
		
		include_once('Google/Client.php');
		include_once('Google/Service/Oauth2.php');
		$client = new Google_Client();
		$client->setClientId('394104292735-09lpvugg7kag9v6444i4481kevahjvs0.apps.googleusercontent.com');
		$client->setClientSecret('oYIErctPRz_gOKVrDtKu32Xb');
		$client->setRedirectUri('http://concursomedellin2018.com/tm/usuario/registro/google');
		$client->setScopes(
			array(
				"https://www.googleapis.com/auth/plus.login",
				"https://www.googleapis.com/auth/plus.me", 
				"https://www.googleapis.com/auth/userinfo.email", 
				"https://www.googleapis.com/auth/userinfo.profile", 
			)
		);
		
		$authUrl = $client->createAuthUrl();
		
		if ( isset($_GET['code']) ) {
			$client->authenticate( $_GET['code'] );
			$accessToken = json_decode($client->getAccessToken());

			$authkey = $this->registrar_por_red_social('google', $accessToken->access_token);
			Yii::app()->session['key'] = $authkey;
	        $this->redirect( array('/usuario/registro/crearclave') );
			
		}
		else
		{
			$this->redirect( $authUrl );
		}
    	
    }

    public function actionCrearclave( $id = '' )
    {
		if( !isset(Yii::app()->session['key']) || empty(Yii::app()->session['key']) )
		{
			if( $id == '' )
				$this->redirect( array('/usuario') );
			else
				Yii::app()->session['key'] = $id;
		}

		$claveForm = new ClaveForm;

		if( isset($_POST['ClaveForm']) ){
			$claveForm->attributes = $_POST['ClaveForm'];
			$usuario_cruge = Yii::app()->user->um->loadUser($claveForm->correo);
			if($claveForm->terminos != 1 )
			{
				Yii::app()->user->setFlash('error', 'Debes aceptar los términos.');
			}elseif( $usuario_cruge->authkey == Yii::app()->session['key'])
			{
				unset( Yii::app()->session['key'] );
				Yii::app()->user->um->changePassword($usuario_cruge, $claveForm->contrasena);
				Yii::app()->user->um->activateAccount($usuario_cruge);
	            $usuario_cruge->authkey = NULL;
				if( Yii::app()->user->um->save($usuario_cruge) )
				{
					$mensaje = 'red_social';
					Yii::app()->user->setFlash('bienvenido', $mensaje);
					Yii::app()->user->setFlash('nombre', $usuario_cruge->username);
					//$usuario = Yii::app()->user->um->loginUser($claveForm->correo);
					$model = Yii::app()->user->um->getNewCrugeLogon('login');
        			$model->authMode = CrugeFactory::get()->getConfiguredAuthMethodName();
        			$model->username = $claveForm->correo;
        			$model->password = $claveForm->contrasena;
        			Yii::app()->session['autologin'] = true;
        			if ($model->validate())
                		$model->login(false);
					$this->redirect( array('/usuario/registro/bienvenido') );
				}
			}else
			{
				Yii::app()->user->setFlash('error', 'Hubo un error guardando la contraseña, por favor repita el proceso.');
			}	
		}

		$authkey = Yii::app()->session['key'];
		if(!$authkey) $this->redirect(array('/usuario'));
		$model = Yii::app()->user->um->loadUserByKey($authkey);
		if(!$model->email) $this->redirect(array('/usuario'));
		$claveForm->correo = $model->email;
		$this->render('crear_clave', array('model' => $claveForm));
		
	}

	private function registrar_por_red_social($key, $token)
	{
		if ( $key == 'google' )
		{
			$fieldmap = array(
				'username' => 'username',
				'email' => 'email',
				'nombres' => 'given_name', 
				'apellidos' => 'family_name',
				'nacimiento' => 'birthday', 
				'sexo' => 'gender', 
			);

			$q 	  = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$token;
			$json = file_get_contents($q);
			$user_profile = json_decode($json, true);
		}

		if( $key == 'facebook' )
		{
			$fieldmap = array(
				'username' => 'username',
				'email' => 'email',
				'nombres' => 'first_name', 
				'apellidos' => 'last_name',
				'nacimiento' => 'birthday', 
				'sexo' => 'gender', 
			);
			Yii::import('application.vendors.Facebook.*');
			include_once('facebook.php');
			$facebook = new Facebook(array(
				'appId'  => '274957429359215',
				'secret' => '2f021bff5939f3ffe097b5e29a1baec4',
			));
			$facebook->setAccessToken($token);
			$user_profile = $facebook->api('/me');
		}

		if( $user_profile )
		{
			$usuario = new Usuario('insert');
			$usuario_cruge = $usuario->registrar_usuario_cruge( $user_profile['email'] );
		
			$mapped_values = new stdClass();
			foreach($fieldmap as $localfield => $remotefield){
				$mapped_values->$localfield = '';
				if( isset($user_profile[ $remotefield ]) )
					$mapped_values->$localfield = $user_profile[$remotefield];
			}
			
			$usuario_id = $usuario->guardar_datos_usuario( $usuario_cruge, $mapped_values );
			
			if($usuario_id)
			{
				return $usuario_cruge->authkey;
			}
			else
			{
				$error = 'no se pudo guardar la información del usuario';
			}
		}else
		{
			$error = 'no se pudo obtener el usuario';
		}
        
        Yii::app()->user->setFlash('error', "No se pudo realizar el registro con ".ucfirst($key)." porque " . $error);
		$this->redirect( array('/usuario/registro') );
	}

	public function actionErrorredes($message=''){
		$this->renderText('<h1>Login Error</h1><p>'.$message.'</p>');
	}

	public function actionBienvenido()
	{
		$mensaje = Yii::app()->user->getFlash('bienvenido');
		$nombre  = Yii::app()->user->getFlash('nombre');
		$model = Yii::app()->user->um->getNewCrugeLogon('login');
        $model->authMode = CrugeFactory::get()->getConfiguredAuthMethodName();
        $usuario = Usuario::model()->findByAttributes( array('cruge_user_id' => $nombre->iduser) );
		$this->render('bienvenido', array('mensaje' => $mensaje, 'nombre' => $usuario->nombres, 'model' => $model));
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='correo')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
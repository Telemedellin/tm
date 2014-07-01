<?php
class AdminController extends Controller
{
	public $layout='//layouts/administrador';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			array('CrugeAccessControlFilter'), 
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('ingresar', 'registro', 'salir'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/*
	public function actionIngresar()
	{
		$model = new LoginForm;
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes = $_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
				Yii::app()->session['auth'] = 'True';
				$this->redirect(bu('/administrador'));
				//$this->redirect(Yii::app()->user->returnUrl);
			}
		}
		// display the login form
		$this->render('ingresar', array('model'=>$model));
	}
	/**/

	public function actionIngresar()
	{
		$model = Yii::app()->user->um->getNewCrugeLogon('login');

        // por ahora solo un metodo de autenticacion por vez es usado, aunque sea un array en config/main
        //
        $model->authMode = CrugeFactory::get()->getConfiguredAuthMethodName();

        Yii::app()->user->setFlash('loginflash', null);

        Yii::log(__CLASS__ . "\nactionLogin\n", "info");

        if (isset($_POST[CrugeUtil::config()->postNameMappings['CrugeLogon']])) {
            $model->attributes = $_POST[CrugeUtil::config()->postNameMappings['CrugeLogon']];
            if ($model->validate()) {
                if ($model->login(false) == true) {

                    Yii::log(__CLASS__ . "\nCrugeLogon->login() returns true\n", "info");

                    // a modo de conocimiento, Yii::app()->user->returnUrl es
                    // establecida automaticamente por CAccessControlFilter cuando
                    // preFilter llama a accessDenied quien a su vez llama a
                    // CWebUser::loginRequired que es donde finalmente se llama a setReturnUrl
                    $this->redirect(Yii::app()->user->returnUrl);
                } else {
                    Yii::app()->user->setFlash('loginflash', Yii::app()->user->getLastError());
                }
            } else {
                Yii::log(
                    __CLASS__ . "\nCrugeUser->validate es false\n" . CHtml::errorSummary($model)
                    ,
                    "error"
                );
            }
        }
        $this->render('ingresar', array('model' => $model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionSalir()
	{
		Yii::app()->user->logout();
		Yii::app()->session->clear();
		Yii::app()->session->destroy();
		$this->redirect(bu('/administrador'));
	}

	public function actionRegistro()
	{
		$usuario = new Usuario;

		if(isset($_POST['Usuario']))
		{
			$usuario->attributes = $_POST['Usuario'];
			$usuario->creado = date('Y-m-d H:i:s', time());
        	if($usuario->validate())
        	{
	            if($usuario->save())
	            	$this->redirect('admin');
	            
	        }
		}


		$this->render('registro', array(
				'usuario' => $usuario
			)
		);
	}

	public function actionRecuperarContrasena()
	{
		$model = new RecuperarForm;

		if(isset($_POST['RecuperarForm']))
		{
			$model->attributes = $_POST['RecuperarForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->generarToken())
				$this->render('recuperar-mensaje', array('mensaje' => 'Por favor revisa tu correo electrónico'));
			else
				$this->render('recuperar',array('model'=>$model));
		}else{
			$this->render('recuperar',array('model'=>$model));
		}
		
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$novedades = new CActiveDataProvider(
							'Pagina', 
							array(
							    'criteria'=>array(
							        'condition'=> 'tipo_pagina_id = 3 AND estado = 2',
							        'order' => 'destacado DESC, creado DESC',
							    ),
							    'pagination'=>false,
							) 
						);
		$concursos = new CActiveDataProvider(
							'Micrositio', 
							array(
							    'criteria'=>array(
							        'condition'=>'seccion_id = 8 AND estado = 2',
							        'order'=>'creado DESC',
							    ), 
							    'pagination'=>false,
							) 
						);
		date_default_timezone_set('America/Bogota');
		setlocale(LC_ALL, 'es_ES.UTF-8');
		$sts = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$programacion = new CActiveDataProvider(
							'Programacion', 
							array(
							    'criteria'=>array(
							        'condition' => 'hora_inicio > ' . $sts . 
							        			   ' AND hora_inicio < ' . ($sts + 86400) .
							        			   ' AND t.estado <> 0',
							        'order'=>'hora_inicio ASC',
							        'with'=>array('micrositio'),
							    ),
							    'pagination'=>false,
							)
						);
		$this->render(
			'index', 
			array(
				'novedades' => $novedades,
				'concursos' => $concursos,
				'programacion' => $programacion,
			)
		);
	}
}
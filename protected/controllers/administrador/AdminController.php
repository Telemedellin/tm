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
				$this->redirect(bu('/administrador'));
				//$this->redirect(Yii::app()->user->returnUrl);
			}
		}
		// display the login form
		$this->render('ingresar', array('model'=>$model));
	}
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionSalir()
	{
		Yii::app()->user->logout();
		Yii::app()->session->clear();
		Yii::app()->session->destroy();
		$this->redirect(Yii::app()->homeUrl . '/administrador');
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
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

}
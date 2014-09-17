<?php

class ProgramacionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
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

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'crear','update', 'delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
		date_default_timezone_set('America/Bogota');
		setlocale(LC_ALL, 'es_ES.UTF-8');
		
		$sts = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$tts = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

		if( isset($_GET['dia']) &&  isset($_GET['mes']) )
		{
			$dia = $_GET['dia'];
			$mes = $_GET['mes'];
			$anio = ( isset( $_GET['anio'] ) ) ? $_GET['anio'] : date('Y');
			if( checkdate($mes, $dia, $anio) )
			{
				$sts = mktime(0, 0, 0, $mes, $dia, $anio);
			}
		}

		// set current date
		// parse about any English textual datetime description into a Unix timestamp
		$ts 		= $sts;
		// calculate the number of days since Monday
		$dow 		= date('w', $ts);
		$offset 	= $dow - 1;
		if ($offset < 0) $offset = 6;
		// calculate timestamp for the Monday
		$ts 		= $ts - $offset * 86400;
		$semana 	= array();

		// loop from Monday till Sunday
		for ($i = 0; $i < 7; $i++, $ts += 86400){
		    $semana[] = $ts;
		}
		$menu = ProgramacionW::getMenu($semana, true);

		$model = new Programacion('search');
		$model->hora_inicio = '> ' . $sts;
		$model->hora_fin = '< ' . ($sts + 86400);
		//date("H:i", $data->hora_inicio)
		$model->estado 		= '<> 0';

		if(isset($_GET['Programacion']))
		{
			$model->attributes = $_GET['Programacion'];
		}


		$this->render('index', array(
			'model' => $model,
			'menu' => $menu
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		date_default_timezone_set('America/Bogota');
		setlocale(LC_ALL, 'es_ES.UTF-8');
		$this->render('ver', array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		//Borrar pgArticuloBlog
		$programacion = Programacion::model()->findByPk($id);
		Yii::app()->user->setFlash('mensaje', 'Programación ' . $programacion->micrositio->nombre . ' eliminada con éxito');
		$programacion->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCrear()
	{
		date_default_timezone_set('America/Bogota');
		setlocale(LC_ALL, 'es_ES.UTF-8');
		$programacion = new Programacion;

		if(isset($_POST['Programacion'])){
			$programacion->attributes = $_POST['Programacion'];
			date_default_timezone_set('America/Bogota');
			setlocale(LC_ALL, 'es_ES.UTF-8');
			$programacion->hora_inicio = strtotime($programacion->hora_inicio);
			$programacion->hora_fin = strtotime($programacion->hora_fin);

			if( $programacion->save() )
			{
				Yii::app()->user->setFlash('mensaje', 'Programación ' . $programacion->micrositio->nombre . ' guardada con éxito');
				$this->redirect('index');
			}
				
		} //if(isset($_POST['Programacion']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$this->render('crear',array(
			'model'=>$programacion,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		date_default_timezone_set('America/Bogota');
		setlocale(LC_ALL, 'es_ES.UTF-8');
		$programacion = Programacion::model()->with('micrositio')->findByPk($id);
		
		if(isset($_POST['Programacion'])){
			$programacion->attributes = $_POST['Programacion'];
			date_default_timezone_set('America/Bogota');
			setlocale(LC_ALL, 'es_ES.UTF-8');
			$programacion->hora_inicio = strtotime($programacion->hora_inicio);
			$programacion->hora_fin = strtotime($programacion->hora_fin);
			
			if( $programacion->save() )
			{
				Yii::app()->user->setFlash('mensaje', 'Programacion ' . $programacion->micrositio->nombre . ' modificada con éxito');
				$this->redirect(array('view','id' => $programacion->id));
			}
			
		} //if(isset($_POST['Programacion']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$this->render('modificar',array(
			'model'=>$programacion,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Url the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Programacion::model()->with('micrositio')->findByPk($id);

		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Url $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='url-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('crear','update'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete'),
				'users'=>array('*'),
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

		$dataProvider = new CActiveDataProvider('Programacion', 
													array(
													    'criteria'=>array(
													        'condition' => 'hora_inicio > ' . $sts . 
													        			   ' AND hora_inicio < ' . ($sts + 86400) .
													        			   ' AND t.estado <> 0',
													        'order'=>'hora_inicio ASC',
													        'with'=>array('micrositio'),
													    ),
													    'pagination'=>array('pageSize'=>25),
													    ) );

		$this->render('index', array(
			'dataProvider' => $dataProvider,
			'menu' => $menu
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
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
		$programacion = new Programacion;

		if(isset($_POST['Programacion'])){
			$programacion->attributes = $_POST['Programacion'];

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

		$programacion = Programacion::model()->with('micrositio')->findByPk($id);
		
		if(isset($_POST['Programacion'])){
			$programacion->attributes = $_POST['Programacion'];
			
			if( $programacion->save() )
			{
				Yii::app()->user->setFlash('mensaje', 'Programacion ' . $programacion->nombre . ' modificada con éxito');
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

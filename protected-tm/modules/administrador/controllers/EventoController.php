<?php
class EventoController extends Controller
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
				'users'=>array('@')
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function behaviors()
	{
		return array(
			'utilities'=>array(
                'class'=>'application.components.behaviors.Utilities'
            )
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = Evento::model()->findByPk($id);
		$this->render('ver', array(
			'model' => $model
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$evento = Evento::model()->findByPk($id);
		$evento->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : '../');
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{

		$evento = Evento::model()->findByPk($id);
		
		if(isset($_POST['Evento'])){
			$evento->attributes = $_POST['Evento'];
			date_default_timezone_set('America/Bogota');
			setlocale(LC_ALL, 'es_ES.UTF-8');
			$evento->fecha = strtotime($evento->fecha);
			$evento->hora = strtotime($evento->hora);
			if($evento->save())
			{
				Yii::app()->user->setFlash('success', 'Evento ' . $evento->nombre . ' guardado con éxito');
				$this->redirect(($_POST['returnUrl'])?$_POST['returnUrl']:bu('administrador/pagina/view/' . $evento->pgEventos->pagina_id) );
			}

		} //if(isset($_POST['Evento']))

		$this->render('modificar',array(
			'model'=>$evento,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionCrear($id)
	{
		$evento = new Evento;	
		
		if(isset($_POST['Evento'])){
			$evento->attributes = $_POST['Evento'];
			date_default_timezone_set('America/Bogota');
			setlocale(LC_ALL, 'es_ES.UTF-8');
			$evento->fecha = strtotime($evento->fecha);
			$evento->hora = strtotime($evento->hora);
			if($evento->save())
			{
				Yii::app()->user->setFlash('success', 'Evento ' . $evento->nombre . ' guardado con éxito');
				$this->redirect(($_POST['returnUrl'])?$_POST['returnUrl']:bu('administrador/pagina/view/' . $evento->pgEventos->pagina_id) );
			}

		} //if(isset($_POST['Evento']))

		$pgEventos = ($id)?PgEventos::model()->with('pagina')->findByPk($id)->id:0;
		$evento->pg_eventos_id = $pgEventos;

		$this->render('crear',array(
			'model'=>$evento,
		));
	}

}
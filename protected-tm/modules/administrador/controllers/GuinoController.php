<?php

class GuinoController extends Controller
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

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'guino', 'guino_mobile', 'crear','update', 'delete'),
				'users'=>array('@')
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actions()
	{
		return array(
			'guino'=>array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/guinos/' . date('Y') . '/' . date('m') . '/',
                'param_name' => 'archivoImagen'
            ),
            'guino_mobile'=>array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/guinos/' . date('Y') . '/' . date('m') . '/',
                'param_name' => 'archivoImagenMobile'
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

	public function actionIndex()
	{
		Yii::app()->session->remove('gn');
		
		$model = new Guino('search');
				
		if(isset($_GET['Guino']))
			$model->attributes = $_GET['Guino'];

		$this->render('index', array(
			'model' => $model, 
		));
	}

	public function actionCrear()
	{
		if( !isset(Yii::app()->session['gn']) ) Yii::app()->session['gn'] = 'guinos/' . date('Y') . '/' . date('m') . '/';

		$guino = new Guino;

		if(isset($_POST['Guino'])){
			$guino->attributes = $_POST['Guino'];
			if( isset(Yii::app()->session['gn']) ){
				$gn = Yii::app()->session['gn'];
			}
			$guino->guino 		= ($_POST['Guino']['guino'] != '')?$gn . $_POST['Guino']['guino']:NULL;
			$guino->guino_mobile= ($_POST['Guino']['guino_mobile'] != '')?$gn . $_POST['Guino']['guino_mobile']:NULL;
			
			if(empty($_POST['Guino']['inicio_publicacion']) || $_POST['Guino']['inicio_publicacion'] == '0000-00-00 00:00:00') $guino->inicio_publicacion = NULL;
			if(empty($_POST['Guino']['fin_publicacion']) || $_POST['Guino']['fin_publicacion'] == '0000-00-00 00:00:00') $guino->fin_publicacion = NULL;
			if($guino->save()){
				Yii::app()->user->setFlash('success', 'Guiño ' . $guino->nombre . ' guardado con éxito');
				$this->redirect( array('view', 'id' => $guino->getPrimaryKey()));
			}//if($guino->save())

		} //if(isset($_POST['Guino']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$this->render('crear',array(
			'model'=>$guino,
		));
	}

	public function actionUpdate($id)
	{
		if( !isset(Yii::app()->session['gn']) ) Yii::app()->session['gn'] = 'guinos/' . date('Y') . '/' . date('m') . '/';

		$guino = Guino::model()->findByPk($id);

		if(isset($_POST['Guino'])){
			if( isset(Yii::app()->session['gn']) ){
				$gn = Yii::app()->session['gn'];
			}
			if($guino->guino != $_POST['Guino']['guino'])
			{
				@unlink( Yii::getPathOfAlias('webroot').'/images/' . $guino->guino);
				$guinon = ($_POST['Guino']['guino'] != '')?$gn . $_POST['Guino']['guino']:NULL;
			}
			if($_POST['Guino']['guino_mobile'] != $guino->guino_mobile)
			{
				@unlink( Yii::getPathOfAlias('webroot').'/images/' . $guino->guino_mobile);
				$guino_mobile 	= ($_POST['Guino']['guino_mobile'] != '')?$gn . $_POST['Guino']['guino_mobile']:NULL;
			}
			$guino->attributes = $_POST['Guino'];
			if(isset($guinon)) $guino->guino 	= $guinon;
			if(isset($guino_mobile)) $guino->guino_mobile 	= $guino_mobile;
			
			if(empty($_POST['Guino']['inicio_publicacion']) || $_POST['Guino']['inicio_publicacion'] == '0000-00-00 00:00:00') $guino->inicio_publicacion = NULL;
			if(empty($_POST['Guino']['fin_publicacion']) || $_POST['Guino']['fin_publicacion'] == '0000-00-00 00:00:00') $guino->fin_publicacion = NULL;
			if($guino->save()){
				Yii::app()->user->setFlash('success', 'Guiño ' . $guino->nombre . ' guardado con éxito');
				$this->redirect( array('view', 'id' => $guino->getPrimaryKey()));
			}//if($guino->save())

		} //if(isset($_POST['Guino']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$this->render('update',array(
			'model'=>$guino,
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = Guino::model()->findByPk($id);
		
		$this->render('ver', array('model' => $model));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$guino = Guino::model()->findByPk($id);
		$guino->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : '../');
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
		$model = Guino::model()->findByPk($id);

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

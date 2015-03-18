<?php

class AlbumvideoController extends Controller
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
				'actions'=>array('view', 'crear','update', 'delete', 'miniatura'),
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
            'miniatura'=> array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/videos/',
                'param_name' => 'archivoMiniatura',
                'image_versions' => 
					array(
						'' => array('max_width' => 240, 'max_height' => 180)
					)
            )
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
		$model = AlbumVideo::model()->with('url', 'micrositio')->findByPk($id);
		$videos = new CActiveDataProvider( 'Video', array(
													    'criteria'=>array(
													        'condition'=>'album_video_id = '.$id,
													        'with'=>array('proveedorVideo', 'url'),
													    )) );
		$this->render('ver', array(
			'model' => $model,
			'videos' => $videos
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$av = AlbumVideo::model()->findByPk($id);
		$av->delete();
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : '../');
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCrear($id)
	{

		$micrositio = ($id)?Micrositio::model()->with('seccion')->findByPk($id):0;
		$album_video = new AlbumVideo;	
		$album_video->micrositio_id = $micrositio->id;

		if(isset($_POST['AlbumVideo'])){
			$album_video->attributes = $_POST['AlbumVideo'];
			$album_video->thumb 	 = 'videos/' . $_POST['AlbumVideo']['thumb'];
			
			if($album_video->save()){
				Yii::app()->user->setFlash('success', $album_video->nombre . ' guardado con éxito');
				$this->redirect( array('view', 'id' => $album_video->id));
			}//if($album_video->save())

		} //if(isset($_POST['AlbumVideo']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		
		$this->render('crear',array(
			'model'=>$album_video,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$album_video = AlbumVideo::model()->findByPk($id);
		$micrositio = Micrositio::model()->with('seccion')->findByPk($album_video->micrositio_id);

		if(isset($_POST['AlbumVideo'])){
			$t = $album_video->thumb;
			$nombre = $album_video->nombre;
			$album_video->attributes = $_POST['AlbumVideo'];
			
			if($_POST['AlbumVideo']['thumb'] != $t)
			{
				@unlink( Yii::getPathOfAlias('webroot').'/images/' . $album_video->thumb);
				$album_video->thumb 	= 'videos/' . $_POST['AlbumVideo']['thumb'];
			}
			if($album_video->save()){
				Yii::app()->user->setFlash('success', $album_video->nombre . ' guardado con éxito');
				$this->redirect( array(strtolower($micrositio->seccion->nombre).'/view', 'id' => $album_video->micrositio_id));
			}//if($album_video->save())

		}//if(isset($_POST['AlbumVideo']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$this->render('modificar',array(
			'model'=>$album_video,
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
		$model = AlbumVideo::model()->with('micrositio')->findByPk($id);

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

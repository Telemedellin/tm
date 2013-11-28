<?php

class VideosController extends Controller
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Video', array(
													    'criteria'=>array(
													        'with'=>array('proveedorVideo', 'url', 'albumVideo'),
													    )) );
		$this->render('index', array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = Video::model()->with('url', 'albumVideo', 'proveedorVideo')->findByPk($id);
		
		$this->render('ver', array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$video = Video::model()->findByPk($id);
		$url_id = $video->url_id;
		//Borrar video

		if($video->delete()){
			//Borrar url de micrositio
			$url = Url::model()->findByPk($url_id);
			$url->delete();	
		}		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCrear($id)
	{
		
		$video = new Video;	

		if(isset($_POST['Video'])){
			$video->attributes = $_POST['Video'];
			if($video->validate()){
				$album_video = AlbumVideo::model()->findByPk($video->album_video_id);
				$url = new Url;
				$slug = '#videos/'.$this->slugger($album_video->nombre).'/'.$this->slugger($video->nombre);
				$slug = $this->verificarSlug($slug);
				$url->slug 		= $slug;
				$url->tipo_id 	= 9; //Video
				$url->estado  	= 1;
				$url->save();
				$video->url_id = $url->getPrimaryKey();

				if( $video->save(false) )
				{
					Yii::app()->user->setFlash('mensaje', 'Video ' . $video->nombre . ' guardado con éxito');
					$this->redirect(bu('administrador/albumvideo/view/'. $album_video->id));
					$this->redirect('index');
				}

			}//if($novedadesForm->validate())

		} //if(isset($_POST['NovedadesForm']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$album_video = ($id)?AlbumVideo::model()->findByPk($id):0;
		$video->album_video_id = $album_video;

		
		$this->render('crear',array(
			'model'=>$video,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{

		$video = Video::model()->with('url', 'proveedorVideo', 'albumVideo')->findByPk($id);

		if(isset($_POST['Video'])){
			$nombre = $video->nombre;
			$video->attributes = $_POST['Video'];
			if($video->validate()){
				if($video->nombre != $nombre){
					$url = Url::model()->findByPk($video->url_id);
					$slug = '#videos/' . $this->slugger($video->albumVideo->nombre).'/'.$this->slugger($video->nombre);
					$slug = $this->verificarSlug($slug);
					$url->slug 		= $slug;
					$url->save(false);
				}

				if( $video->save(false) )
				{
					Yii::app()->user->setFlash('mensaje', 'Video ' . $video->nombre . ' guardado con éxito');
					$this->redirect(array('view','id' => $video->id));
				}

			}//if($novedadesForm->validate())

		} //if(isset($_POST['NovedadesForm']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$this->render('modificar',array(
			'model'=>$video,
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
		$model = Micrositio::model()->with('url', 'pagina')->findByPk($id);

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

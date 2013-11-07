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
		$album_video = AlbumVideo::model()->findByPk($id);
		$album_video->delete();
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

		$micrositio = ($id)?Micrositio::model()->with('seccion')->findByPk($id):0;
		$album_video = new AlbumVideo;	
		$album_video->micrositio_id = $micrositio;

		if(isset($_POST['AlbumVideo'])){
			$album_video->attributes = $_POST['AlbumVideo'];
			$album_video->thumb 	 = 'videos/' . $album_video->thumb;
			
			$url = new Url;
			$url->slug 		= '#videos/' . $this->slugger($album_video->nombre);
			$url->tipo_id 	= 8; //Álbum de videos
			$url->estado  	= 1;
			$url->save();
			
			$album_video->url_id = $url->getPrimaryKey();

			if($album_video->save()){
				Yii::app()->user->setFlash('mensaje', $album_video->nombre . ' guardado con éxito');
					$this->redirect(bu('administrador/'.$micrositio->seccion->nombre.'/view/' . $micrositio->id));
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
			if($album_video->nombre != $nombre){
				$url = Url::model()->findByPk($album_video->url_id);
				$url->slug 		= '#videos/' . $this->slugger($album_video->nombre);
				$url->save(false);
			}
			if($_POST['AlbumVideo']['thumb'] != $t)
			{
				@unlink( Yii::getPathOfAlias('webroot').'/images/' . $album_video->thumb);
				$album_video->thumb 	= 'videos/' . $_POST['AlbumVideo']['thumb'];
			}
			if($album_video->save()){
				Yii::app()->user->setFlash('mensaje', $album_video->nombre . ' guardado con éxito');
				$this->redirect(bu('administrador/'.$micrositio->seccion->nombre.'/view/' . $album_video->micrositio_id));
			}//if($album_video->save())

		}//if(isset($_POST['AlbumVideo']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$this->render('modificar',array(
			'model'=>$album_video,
		));
	}

	public function actionMiniatura(){	
		$data = array(	'image_versions' => array( '' => array(	'max_width' => 240,
																'max_height' => 180
															 )
												),
					  	'script_url' => Yii::app()->request->baseUrl.'/administrador/albumvideo/miniatura',
					  	'max_number_of_files' => null,
						'upload_dir' => Yii::getPathOfAlias('webroot').'/images/videos/',
	            		'upload_url' => Yii::app()->request->baseUrl.'/images/videos/',	
	            		'accept_file_types' => '/(\.|\/)(gif|jpe?g|png)$/i',
	            		'param_name' => 'archivoMiniatura',
				);
		$messages = array(
        			1 => 'El archivo subido excede la directiva upload_max_filesize en php.ini',
        			2 => 'El archivo subido excede la directiva MAX_FILE_SIZE que se especificó en el formulario HTML',
        			3 => 'El archivo subido fue sólo parcialmente cargado. Por favor cargarlo nuevamente.',
        			4 => 'Ningún archivo fue subido',
        			6 => 'La carpeta temporal no se encuentra',
        			7 => 'Falló la escritura en el servidor',
        			8 => 'Una extensión de PHP interrumpió la carga de archivos',
        			'post_max_size' => 'El archivo subido excede la directiva post_max_size en php.ini',
        			'max_file_size' => 'El archivo es demasiado pesado',
        			'min_file_size' => 'El archivo no tiene el peso suficiente',
        			'accept_file_types' => 'Tipo de archivo no permitido',
        			'max_number_of_files' => 'Número máximo de archivos se superó. Solo se permite una miniatura',
        			'max_width' => 'La imagen excede el ancho máximo',
        			'min_width' => 'La imagen no tiene el ancho suficiente',
        			'max_height' => 'La imagen excede el alto máximo',
        			'min_height' => 'La imagen no tiene el alto suficiente'
    			);		
		$upload_handler = new UploadHandler($data, true, $messages);	
	}

	private function slugger($title)
	{
		$characters = array(
			"Á" => "A", "Ç" => "c", "É" => "e", "Í" => "i", "Ñ" => "n", "Ó" => "o", "Ú" => "u", 
			"á" => "a", "ç" => "c", "é" => "e", "í" => "i", "ñ" => "n", "ó" => "o", "ú" => "u",
			"à" => "a", "è" => "e", "ì" => "i", "ò" => "o", "ù" => "u"
		);
		
		$string = strtr($title, $characters); 
		$string = strtolower(trim($string));
		$string = preg_replace("/[^a-z0-9-]/", "-", $string);
		$string = preg_replace("/-+/", "-", $string);
		
		if(substr($string, strlen($string) - 1, strlen($string)) === "-") {
			$string = substr($string, 0, strlen($string) - 1);
		}
		
		return $string;
	}
	private function verificarSlug($slug)
	{
		$c = Url::model()->findByAttributes(array('slug' => $slug));
		if($c)
        {
        	$lc = substr($slug, -1);
        	if(is_numeric(substr($slug, -1)))
        	{
        		$slug = substr($slug, 0, -1) . ($lc+1);	
        	}else
        	{
        		$slug += '-1';
        	}
        	$slug = $this->verificarSlug($slug);
        }
        return $slug;
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

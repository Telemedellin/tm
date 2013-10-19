<?php

class ConcursosController extends Controller
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
				'actions'=>array('index','view', 'imagen', 'miniatura'),
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
		Yii::app()->session->destroy();
		$dataProvider = new CActiveDataProvider('Micrositio', array(
													    'criteria'=>array(
													        'condition'=>'seccion_id = 8',
													        'order'=>'creado DESC',
													        /*'with'=>array('author'),*/
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
		$model = Micrositio::model()->with('url', 'pagina')->findByPk($id);
		$contenido = PgGenericaSt::model()->findByAttributes(array('pagina_id' => $model->pagina->id));
		$this->render('ver', array(
			'model' => $model,
			'contenido' => $contenido
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
		$pgAB = pgArticuloBlog::model()->findByAttributes(array('pagina_id' => $id));
		$imagen = $pgAB->imagen;
		$miniatura = $pgAB->miniatura;
		$transaccion = $pgAB->dbConnection->beginTransaction();
		if( $pgAB->delete() )
		{
			//Borrar Página
			$pagina = Pagina::model()->findByPk($id);
			$url_id = $pagina->url_id;
			if( $pagina->delete() ){
				//Borrar Url
				$url = Url::model()->findByPk($url_id);
				if($url->delete()){
					$transaccion->commit();
					//Borrar Archivos
					unlink( Yii::getPathOfAlias('webroot').'/images/' . $miniatura);
					unlink( Yii::getPathOfAlias('webroot').'/images/' . $imagen);
				}else{
					$transaccion->rollback();
				}
			}else{
				$transaccion->rollback();		
			}
			
		}else
		{
			$transaccion->rollback();
		}
		echo 'hola';
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
		if( !isset(Yii::app()->session['dirc']) ) Yii::app()->session['dirc'] = 'concursos/' . date('Y') . '/' . date('m') . '/';

		$concursosForm = new ConcursosForm;

		if(isset($_POST['ConcursosForm'])){
			$concursosForm->attributes = $_POST['ConcursosForm'];
			if( isset(Yii::app()->session['dirc']) ){
				$dirc = Yii::app()->session['dirc'];
			}
			if($concursosForm->validate()){
				$url = new URL;
				$transaccion 	= $url->dbConnection->beginTransaction();
				$url->slug 		= 'concursos/' . $this->slugger($concursosForm->nombre);
				$url->tipo_id 	= 2; //Micrositio
				$url->estado  	= 1;
				if( !$url->save(false) ) $transaccion->rollback();
				$url_id = $url->getPrimaryKey();

				$micrositio = new Micrositio;
				$micrositio->seccion_id 	= 8; //Concursos
				$micrositio->usuario_id 	= 1;
				$micrositio->url_id 		= $url_id;
				$micrositio->nombre			= $concursosForm->nombre;
				$micrositio->background 	= $dirc . $concursosForm->imagen;
				$micrositio->miniatura 		= $dirc . 'thumbnail/' . $concursosForm->miniatura;
				$micrositio->destacado		= $concursosForm->destacado;
				$micrositio->estado			= $concursosForm->estado;
				if( !$micrositio->save(false) ) $transaccion->rollback();
				$micrositio_id = $micrositio->getPrimaryKey();

				$purl = new Url;
				$purl->slug 	= 'concursos/' . $url->slug .'/inicio';
				$purl->tipo_id 	= 3; //Pagina
				$purl->estado  	= 1;
				if( !$purl->save(false) ) $transaccion->rollback();
				$purl_id = $purl->getPrimaryKey();

				$pagina = new Pagina;
				$pagina->micrositio_id 	= $micrositio_id;
				$pagina->tipo_pagina_id = 2; //Generica
				$pagina->url_id 		= $purl_id;
				$pagina->nombre			= $concursosForm->nombre;
				$pagina->clase 			= NULL;
				$pagina->destacado		= $concursosForm->destacado;
				$pagina->estado			= $concursosForm->estado;
				if( !$pagina->save(false) ) $transaccion->rollback();
				$pagina_id = $pagina->getPrimaryKey();

				$micrositio->pagina_id = $pagina_id;
				$micrositio->save(false);

				$pgGst = new PgGenericaSt;
				$pgGst->pagina_id 	= $pagina_id;
				$pgGst->texto 		= $concursosForm->texto;
				$pgGst->estado 		= 1;
				
				if( !$pgGst->save(false) )
					$transaccion->rollback();
				else
				{
					$transaccion->commit();
					Yii::app()->user->setFlash('mensaje', 'Concurso ' . $concursosForm->nombre . ' guardado con éxito');
					$this->redirect('index');
				}
				

			}//if($novedadesForm->validate())

		} //if(isset($_POST['NovedadesForm']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$this->render('crear',array(
			'model'=>$concursosForm,
		));
	}

	public function actionImagen(){	
		if(isset(Yii::app()->session['dirc'])){
			$dirc = Yii::app()->session['dirc'];
		}
		$data = array(	/*'image_versions' => array( 'thumbnail' => array(	'max_width' => 50,
																		'max_height' => 35
																	 )
												),*/
					  	'script_url' => Yii::app()->request->baseUrl.'/administrador/concursos/imagen',
					  	'max_number_of_files' => null,
						'upload_dir' => Yii::getPathOfAlias('webroot').'/images/' . $dirc,
	            		'upload_url' => Yii::app()->request->baseUrl.'/images/' . $dirc,	
	            		'accept_file_types' => '/(\.|\/)(gif|jpe?g|png)$/i',
	            		'param_name' => 'archivoImagen',
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
        			'max_number_of_files' => 'Número máximo de archivos se superó. Solo se permite una imagen',
        			'max_width' => 'La imagen excede el ancho máximo',
        			'min_width' => 'La imagen no tiene el ancho suficiente',
        			'max_height' => 'La imagen excede el alto máximo',
        			'min_height' => 'La imagen no tiene el alto suficiente'
    			);		
		$upload_handler = new UploadHandler($data, true, $messages);	
	}

	public function actionMiniatura(){	
		if(isset(Yii::app()->session['dirc'])){
			$dirc = Yii::app()->session['dirc'];
		}
		$data = array(	'image_versions' => array( '' => array(	'max_width' => 50,
																'max_height' => 35
															 )
												),
					  	'script_url' => Yii::app()->request->baseUrl.'/administrador/concursos/imagen',
					  	'max_number_of_files' => null,
						'upload_dir' => Yii::getPathOfAlias('webroot').'/images/' . $dirc . 'thumbnail/',
	            		'upload_url' => Yii::app()->request->baseUrl.'/images/' . $dirc . 'thumbnail/',	
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
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{

		if( !isset(Yii::app()->session['dirc']) ) Yii::app()->session['dirc'] = 'concursos/' . date('Y') . '/' . date('m') . '/';

		$micrositio = Micrositio::model()->with('url', 'pagina')->findByPk($id);
		$pagina = Pagina::model()->with('url', 'pgGenericaSts')->findByAttributes(array('micrositio_id' => $micrositio->id));
		
		$concursosForm = new ConcursosForm;
		$concursosForm->id = $id;
		$concursosForm->nombre = $micrositio->nombre;
		$concursosForm->texto = $pagina->pgGenericaSts->texto;
		$concursosForm->imagen = $micrositio->background;
		$concursosForm->miniatura = $micrositio->miniatura;
		$concursosForm->estado = $micrositio->estado;
		$concursosForm->destacado = $micrositio->destacado;

		if(isset($_POST['ConcursosForm'])){
			$concursosForm->attributes = $_POST['ConcursosForm'];
			if( isset(Yii::app()->session['dirc']) ){
				$dirc = Yii::app()->session['dirc'];
			}
			if($concursosForm->validate()){
				if($concursosForm->nombre != $micrositio->nombre){
					$url = URL::model()->findByPk($micrositio->url_id);
					$url->slug 		= 'concursos/' . $this->slugger($concursosForm->nombre);
					$url->save(false);

					$purl = Url::model()->findByPk($pagina->url_id);
					$purl->slug 	= 'concursos/' . $url->slug .'/inicio';
					$purl->save(false);
				}

				$micrositio = Micrositio::model()->findByPk($id);
				$transaccion 	= $micrositio->dbConnection->beginTransaction();
				$micrositio->nombre			= $concursosForm->nombre;
				if($dirc . $concursosForm->imagen != $micrositio->background)
				{
					unlink( Yii::getPathOfAlias('webroot').'/images/' . $micrositio->background);
					$micrositio->background 	= $dirc . $concursosForm->imagen;
				}
				if($dirc . $concursosForm->miniatura != $micrositio->miniatura)
				{
					unlink( Yii::getPathOfAlias('webroot').'/images/' . $micrositio->miniatura);
					$micrositio->miniatura 	= $dirc . $concursosForm->miniatura;
				}

				$micrositio->destacado		= $concursosForm->destacado;
				$micrositio->estado			= $concursosForm->estado;
				if( !$micrositio->save(false) ) $transaccion->rollback();

				$pagina = Pagina::model()->findByAttributes(array('micrositio_id' => $micrositio->id));
				$pagina->nombre			= $concursosForm->nombre;
				$pagina->destacado		= $concursosForm->destacado;
				$pagina->estado			= $concursosForm->estado;
				if( !$pagina->save(false) ) $transaccion->rollback();

				$pgGst = PgGenericaSt::model()->findByAttributes( array('pagina_id' => $pagina->id) );
				$pgGst->texto 		= $concursosForm->texto;
				
				if( !$pgGst->save(false) )
					$transaccion->rollback();
				else
				{
					$transaccion->commit();
					Yii::app()->user->setFlash('mensaje', 'Concurso ' . $concursosForm->nombre . ' guardado con éxito');
					$this->redirect(array('view','id' => $concursosForm->id));
				}
				

			}//if($novedadesForm->validate())

		} //if(isset($_POST['NovedadesForm']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$this->render('modificar',array(
			'model'=>$concursosForm,
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

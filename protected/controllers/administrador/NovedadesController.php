<?php

class NovedadesController extends Controller
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
		$dataProvider = new CActiveDataProvider('Pagina', array(
													    'criteria'=>array(
													        'condition'=>'tipo_pagina_id = 3',
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
		if( !isset(Yii::app()->session['dir']) ) Yii::app()->session['dir'] = 'novedades/' . date('Y') . '/' . date('m') . '/';

		$novedadesForm = new NovedadesForm;

		if(isset($_POST['NovedadesForm'])){
			$novedadesForm->attributes = $_POST['NovedadesForm'];
			if( isset(Yii::app()->session['dir']) ){
				$dir = Yii::app()->session['dir'];
			}
			if($novedadesForm->validate()){
				$url = new URL;
				$transaccion 	= $url->dbConnection->beginTransaction();
				$url->slug 		= 'novedades/' . $this->slugger($novedadesForm->nombre);
				$url->tipo_id 	= 3; //Página
				$url->estado  	= 1;
				if( !$url->save(false) ) $transaccion->rollback();
				$url_id = $url->getPrimaryKey();

				$pagina = new Pagina;
				$pagina->micrositio_id 	= 2; //Novedades
				$pagina->tipo_pagina_id = 3; //Novedad
				$pagina->url_id 		= $url_id;
				$pagina->nombre			= $novedadesForm->nombre;
				$pagina->clase 			= NULL;
				$pagina->destacado		= $novedadesForm->destacado;
				if( !$pagina->save(false) ) $transaccion->rollback();
				$pagina_id = $pagina->getPrimaryKey();

				$pgAB = new pgArticuloBlog;
				$pgAB->pagina_id 	= $pagina_id;
				$pgAB->entradilla 	= $novedadesForm->entradilla;
				$pgAB->texto 		= $novedadesForm->texto;
				$pgAB->imagen 		= $dir . $novedadesForm->imagen;
				$pgAB->miniatura 	= $dir . 'thumbnail/' . $novedadesForm->miniatura;
				$pgAB->estado 		= 1;
				
				if( !$pgAB->save(false) )
					$transaccion->rollback();
				else
				{
					$transaccion->commit();
					Yii::app()->user->setFlash('mensaje', 'Novedad ' . $novedadesForm->nombre . ' guardada con éxito');
					$this->redirect('index');
				}
				

			}//if($novedadesForm->validate())

		} //if(isset($_POST['NovedadesForm']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$this->render('crear',array(
			'model'=>$novedadesForm,
		));
	}

	public function actionImagen(){	
		if(isset(Yii::app()->session['dir'])){
			$dir = Yii::app()->session['dir'];
		}
		$data = array(	/*'image_versions' => array( 'thumbnail' => array(	'max_width' => 50,
																		'max_height' => 35
																	 )
												),*/
					  	'script_url' => Yii::app()->request->baseUrl.'/administrador/novedades/imagen',
					  	'max_number_of_files' => null,
						'upload_dir' => Yii::getPathOfAlias('webroot').'/images/' . $dir,
	            		'upload_url' => Yii::app()->request->baseUrl.'/images/' . $dir,	
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
		if(isset(Yii::app()->session['dir'])){
			$dir = Yii::app()->session['dir'];
		}
		$data = array(	'image_versions' => array( '' => array(	'max_width' => 50,
																'max_height' => 35
															 )
												),
					  	'script_url' => Yii::app()->request->baseUrl.'/administrador/novedades/imagen',
					  	'max_number_of_files' => null,
						'upload_dir' => Yii::getPathOfAlias('webroot').'/images/' . $dir . 'thumbnail/',
	            		'upload_url' => Yii::app()->request->baseUrl.'/images/' . $dir . 'thumbnail/',	
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

		if( !isset(Yii::app()->session['dir']) ) Yii::app()->session['dir'] = 'novedades/' . date('Y') . '/' . date('m') . '/';

		$pagina = Pagina::model()->with('url', 'pgArticuloBlogs')->findByPk($id);
		$novedadesForm = new NovedadesForm;
		$novedadesForm->id = $id;
		$novedadesForm->nombre = $pagina->nombre;
		$novedadesForm->entradilla = $pagina->pgArticuloBlogs->entradilla;
		$novedadesForm->texto = $pagina->pgArticuloBlogs->texto;
		$novedadesForm->imagen = $pagina->pgArticuloBlogs->imagen;
		$novedadesForm->miniatura = $pagina->pgArticuloBlogs->miniatura;
		$novedadesForm->estado = $pagina->estado;
		$novedadesForm->destacado = $pagina->destacado;

		if(isset($_POST['NovedadesForm'])){
			$novedadesForm->attributes = $_POST['NovedadesForm'];
			if( isset(Yii::app()->session['dir']) ){
				$dir = Yii::app()->session['dir'];
			}
			if($novedadesForm->validate()){
				if($novedadesForm->nombre != $pagina->nombre){
					$url = URL::model()->findByPk($pagina->url_id);
					$url->slug 		= 'novedades/' . $this->slugger($novedadesForm->nombre);
					$url->save(false);
				}
				
				$pagina = Pagina::model()->findByPk($id);
				$transaccion 	= $pagina->dbConnection->beginTransaction();

				$pagina->nombre			= $novedadesForm->nombre;
				$pagina->destacado		= $novedadesForm->destacado;
				$pagina->estado			= $novedadesForm->estado;
				if( !$pagina->save(false) ) $transaccion->rollback();
				$pagina_id = $pagina->id;

				$pgAB = pgArticuloBlog::model()->findByAttributes(array('pagina_id' => $pagina_id));

				if($dir . $novedadesForm->imagen != $pgAB->imagen)
				{
					unlink( Yii::getPathOfAlias('webroot').'/images/' . $pgAB->imagen);
					$pgAB->imagen 	= $dir . $novedadesForm->imagen;
				}
				if($dir . $novedadesForm->miniatura != $pgAB->miniatura)
				{
					unlink( Yii::getPathOfAlias('webroot').'/images/' . $pgAB->miniatura);
					$pgAB->miniatura 	= $dir . $novedadesForm->miniatura;
				}

				$pgAB->entradilla 	= $novedadesForm->entradilla;
				$pgAB->texto 		= $novedadesForm->texto;
				$pgAB->estado 		= $novedadesForm->estado;
				
				if( !$pgAB->save(false) )
					$transaccion->rollback();
				else
				{
					$transaccion->commit();
					Yii::app()->user->setFlash('mensaje', 'Novedad ' . $novedadesForm->nombre . ' modificada con éxito');
					$this->redirect(array('view','id' => $novedadesForm->id));
				}
				

			}//if($novedadesForm->validate())

		} //if(isset($_POST['NovedadesForm']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$this->render('modificar',array(
			'model'=>$novedadesForm,
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
		$model = Pagina::model()->with('url', 'pgArticuloBlogs')->findByPk($id);

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

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
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
													        /*'order'=>'create_time DESC',
													        'with'=>array('author'),*/
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCrear()
	{
		if( !isset(Yii::app()->session['dir']) ) Yii::app()->session['dir'] = date('Y') . '/' . date('m') . '/';

		$novedadesForm = new NovedadesForm;

		if(isset($_POST['NovedadesForm'])){
			$novedadesForm->attributes = $_POST['RegistroForm'];
			if( isset(Yii::app()->session['dir']) ){
				$dir = Yii::app()->session['dir'];
			}
			if($novedadesForm->validate()){
				$url = new URL;
				$transaccion 	= $url->dbConnection->beginTransaction();
				$url->slug 		= $this->slugger($novedadesForm->nombre);
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


				if( is_dir(Yii::getPathOfAlias('webroot').'/images/novedades/' . $dir) ){
					$directorio = dir( Yii::getPathOfAlias('webroot').'/images/novedades/' . $dir ); 
					while ( $archivo = $directorio->read() ){
						if( $archivo !== "." && $archivo !== ".." && $archivo !== "thumbnail" ){					
							$imagen = 'novedades/' . $dir . $archivo;
							break;
						}
					}								
					$directorio->close(); 					
				}//if( is_dir(Yii::getPathOfAlias('webroot').'/images/novedades/' . $dir) )
				else
				{
					//Hacer algo porque la imagen es obligatoria
					$transaccion->rollback();
				}
				if( is_dir(Yii::getPathOfAlias('webroot').'/images/novedades/' . $dir . 'thumbnail/') ){
					$tdirectorio = dir( Yii::getPathOfAlias('webroot').'/images/novedades/' . $dir . 'thumbnail/' ); 
					while ( $tarchivo = $tdirectorio->read() ){
						if( $tarchivo !== "." && $tarchivo !== ".." && $tarchivo !== "thumbnail" ){					
							$miniatura = 'novedades/' . $dir . 'thumbnail/' . $tarchivo;
							break;
						}
					}								
					$tdirectorio->close(); 					
				}//if( is_dir(Yii::getPathOfAlias('webroot').'/images/novedades/' . $dir) )
				else
				{
					//Hacer algo porque la imagen es obligatoria
					$transaccion->rollback();
				}

				$pgAB->imagen 		= $imagen;
				$pgAB->miniatura 	= $miniatura;
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
		/*
		if(isset($_POST['NovedadesForm']))
		{
			$model->attributes = $_POST['NovedadesForm'];
			/*if($model->save())
				$this->redirect(array('view','id'=>$model->id));*/
		//}

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
					  	'max_number_of_files' => 1,
						'upload_dir' => Yii::getPathOfAlias('webroot').'/images/novedades/' . $dir,
	            		'upload_url' => Yii::app()->request->baseUrl.'/images/novedades/' . $dir,	
	            		'accept_file_types' => '/(\.|\/)(gif|jpe?g|png)$/i',
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
        			'max_number_of_files' => 'Número máximo de archivos se superó. Solo se permite una foto de perfil',
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
		$data = array(	/*'image_versions' => array( 'thumbnail' => array(	'max_width' => 50,
																		'max_height' => 35
																	 )
												),*/
					  	'script_url' => Yii::app()->request->baseUrl.'/administrador/novedades/imagen',
					  	'max_number_of_files' => 1,
						'upload_dir' => Yii::getPathOfAlias('webroot').'/images/novedades/' . $dir . 'thumbnail/',
	            		'upload_url' => Yii::app()->request->baseUrl.'/images/novedades/' . $dir . 'thumbnail/',	
	            		'accept_file_types' => '/(\.|\/)(gif|jpe?g|png)$/i',
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
        			'max_number_of_files' => 'Número máximo de archivos se superó. Solo se permite una foto de perfil',
        			'max_width' => 'La imagen excede el ancho máximo',
        			'min_width' => 'La imagen no tiene el ancho suficiente',
        			'max_height' => 'La imagen excede el alto máximo',
        			'min_height' => 'La imagen no tiene el alto suficiente'
    			);		
		$upload_handler = new UploadHandler($data, true, $messages);	
	}

	private function slugger($title)
	{
		$slug = preg_replace('@[\s!:;_\?=\\\+\*/%&#]+@', '-', $title);
        if (true === $this->toLower) {
            $slug = mb_strtolower($slug, \Yii::app()->charset);
        }
        $slug = trim($slug, '-');

        $slug = $this->verificarSlug($slug);

        return $slug;
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Url']))
		{
			$model->attributes=$_POST['Url'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	



	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Url('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Url']))
			$model->attributes=$_GET['Url'];

		$this->render('admin',array(
			'model'=>$model,
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

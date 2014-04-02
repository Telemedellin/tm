<?php

class DocumentalesController extends Controller
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
				'actions'=>array('index','view', 'imagen', 'imagen_mobile', 'miniatura', 'crear','update', 'delete'),
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
			'imagen'=>array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/backgrounds/documentales/',
                'param_name' => 'archivoImagen'
            ),
            'imagen_mobile'=>array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/backgrounds/documentales/',
                'param_name' => 'archivoImagenMobile'
            ),
            'miniatura'=> array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/backgrounds/documentales/thumbnail/',
                'param_name' => 'archivoMiniatura',
                'image_versions' => 
					array(
						'' => array('max_width' => 250, 'max_height' => 150)
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		Yii::app()->session->remove('dird');
		$dataProvider = new CActiveDataProvider('Micrositio', array(
													    'criteria'=>array(
													        'condition'=>'seccion_id = 4',
													        'order'=>'t.nombre ASC',
													        'with'=>array('url'),
													    ),
													    'pagination'=>array(
													    	'pageSize'=>25,
													    )
													) );
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
		$contenido = PgDocumental::model()->findByAttributes(array('pagina_id' => $model->pagina->id));
		$ficha_tecnica = new CActiveDataProvider( 'FichaTecnica', array(
													    'criteria'=>array(
													        'condition'=>'pg_documental_id = '.$contenido->id,
													        'order'=>'t.orden ASC'
													    )) );
		$videos = new CActiveDataProvider( 'AlbumVideo', array(
													    'criteria'=>array(
													        'condition'=>'micrositio_id = '.$id,
													        'with'=>array('videos', 'url'),
													    )) );

		$paginas = new CActiveDataProvider( 'Pagina', array(
													    'criteria'=>array(
													        'condition'=>'micrositio_id=' . $id . ' AND tipo_pagina_id=4',
													        'with'=>array('pgDocumentals', 'url'),
													    )) );

		$this->render('ver', array(
			'model' => $model,
			'contenido' => $contenido,
			'ficha_tecnica' => $ficha_tecnica,
			'videos' => $videos, 
			'paginas' => $paginas
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$micrositio = Micrositio::model()->findByPk($id);
		$imagen = $micrositio->background;
		$imagen_mobile = $micrositio->background_mobile;
		$miniatura = $micrositio->miniatura;
		$url_id = $micrositio->url_id;
		$micrositio->pagina_id = null;
		$micrositio->save();
		$pagina = Pagina::model()->findByAttributes( array('micrositio_id' =>$micrositio->id) );
		$urlp_id = $pagina->url_id;
		//Borrar PgPrograma
		$PgP = PgDocumental::model()->findByAttributes(array('pagina_id' => $pagina->id));
		$transaccion = $PgP->dbConnection->beginTransaction();
		if( $PgP->delete() )
		{
			//Borrar Página
			if( $pagina->delete() ){
				//Borrar Url de pagina
				$urlp = Url::model()->findByPk($urlp_id);
				//Borrar micrositio

				if($micrositio->delete()){
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $miniatura);
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $imagen_mobile);
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $imagen);
					//Borrar url de micrositio
					$url = Url::model()->findByPk($url_id);
					$url->delete();
					$transaccion->commit();
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
		if( !isset(Yii::app()->session['dird']) ) Yii::app()->session['dird'] = 'backgrounds/documentales/';

		$documentalesForm = new DocumentalesForm;		

		if(isset($_POST['DocumentalesForm'])){
			$documentalesForm->attributes = $_POST['DocumentalesForm'];
			if( isset(Yii::app()->session['dird']) ){
				$dird = Yii::app()->session['dird'];
			}
			if($documentalesForm->validate()){
				$url = new Url;
				$transaccion 	= $url->dbConnection->beginTransaction();
				$slug = 'documentales/' . $this->slugger($documentalesForm->nombre);
				$slug = $this->verificarSlug($slug);
				$url->slug 		= $slug;
				$url->tipo_id 	= 2; //Micrositio
				$url->estado  	= 1;
				if( !$url->save(false) ) $transaccion->rollback();
				$url_id = $url->getPrimaryKey();

				$micrositio = new Micrositio;
				$micrositio->seccion_id 	= 4; //Documentales
				$micrositio->usuario_id 	= 1;
				$micrositio->url_id 		= $url_id;
				$micrositio->nombre			= $documentalesForm->nombre;
				$micrositio->background 	= $dird . $documentalesForm->imagen;
				$micrositio->background_mobile 	= $dird . $documentalesForm->imagen_mobile;
				$micrositio->miniatura 		= $dird . 'thumbnail/' . $documentalesForm->miniatura;
				$micrositio->destacado		= $documentalesForm->destacado;
				if($documentalesForm->estado > 0) $estado = 1;
				else $estado = 0;
				$micrositio->estado			= $estado;
				if( !$micrositio->save(false) ) $transaccion->rollback();
				$micrositio_id = $micrositio->getPrimaryKey();

				$purl = new Url;
				$pslug = $url->slug .'/inicio';
				$pslug = $this->verificarSlug($pslug);
				$purl->slug 	= $pslug;
				$purl->tipo_id 	= 3; //Pagina
				$purl->estado  	= 1;
				if( !$purl->save(false) ) $transaccion->rollback();
				$purl_id = $purl->getPrimaryKey();

				$pagina = new Pagina;
				$pagina->micrositio_id 	= $micrositio_id;
				$pagina->tipo_pagina_id = 1; //Página programa
				$pagina->url_id 		= $purl_id;
				$pagina->nombre			= $documentalesForm->nombre;
				$pagina->clase 			= NULL;
				$pagina->destacado		= $documentalesForm->destacado;
				$pagina->estado			= $estado;
				if( !$pagina->save(false) ) $transaccion->rollback();
				$pagina_id = $pagina->getPrimaryKey();

				$micrositio->pagina_id = $pagina_id;
				$micrositio->save(false);

				$pgD = new PgDocumental;
				$pgD->pagina_id 	= $pagina_id;
				$pgD->titulo 		= $documentalesForm->nombre;
				$pgD->duracion 		= $documentalesForm->duracion;
				$pgD->anio 			= $documentalesForm->anio;
				$pgD->sinopsis 		= $documentalesForm->sinopsis;
				$pgD->estado 		= $documentalesForm->estado;
				
				if( !$pgD->save(false) )
					$transaccion->rollback();
				else
				{
					$transaccion->commit();
					Yii::app()->user->setFlash('mensaje', 'Documental ' . $documentalesForm->nombre . ' guardado con éxito');
					$this->redirect('index');
				}

			}//if($novedadesForm->validate())

		} //if(isset($_POST['NovedadesForm']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		
		$this->render('crear',array(
			'model'=>$documentalesForm,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{

		if( !isset(Yii::app()->session['dird']) ) Yii::app()->session['dird'] = 'backgrounds/documentales/';

		$micrositio = Micrositio::model()->with('url', 'pagina')->findByPk($id);
		$pagina = Pagina::model()->with('url', 'pgDocumentals')->findByAttributes(array('micrositio_id' => $micrositio->id));
		$pgD = PgDocumental::model()->with('fichaTecnicas')->findByAttributes(array('pagina_id' => $pagina->id));

		$documentalesForm = new DocumentalesForm;		
		$documentalesForm->id = $id;

		if(isset($_POST['DocumentalesForm'])){
			$documentalesForm->attributes = $_POST['DocumentalesForm'];
			if( isset(Yii::app()->session['dird']) ){
				$dird = Yii::app()->session['dird'];
			}
			if($documentalesForm->validate()){
				if($documentalesForm->nombre != $micrositio->nombre){
					$url = Url::model()->findByPk($micrositio->url_id);
					$slug = 'documentales/' . $this->slugger($documentalesForm->nombre);
					$slug = $this->verificarSlug($slug);
					$url->slug 		= $slug;
					$url->save(false);

					$purl = Url::model()->findByPk($pagina->url_id);
					$pslug = $url->slug .'/inicio';
					$pslug = $this->verificarSlug($pslug);
					$purl->slug 	= $pslug;
					$purl->save(false);
				}

				$micrositio = Micrositio::model()->findByPk($id);
				$transaccion 	= $micrositio->dbConnection->beginTransaction();
				$micrositio->nombre			= $documentalesForm->nombre;
				if($documentalesForm->imagen != $micrositio->background)
				{
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $micrositio->background);
					$micrositio->background 	= $dird . $documentalesForm->imagen;
				}
				if($documentalesForm->imagen_mobile != $micrositio->background_mobile)
				{
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $micrositio->background_mobile);
					$micrositio->background_mobile 	= $dird . $documentalesForm->imagen_mobile;
				}
				if($documentalesForm->miniatura != $micrositio->miniatura)
				{
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $micrositio->miniatura);
					$micrositio->miniatura 	= $dird . $documentalesForm->miniatura;
				}

				$micrositio->destacado		= $documentalesForm->destacado;
				if($documentalesForm->estado > 0) $estado = 1;
				else $estado = 0;
				
				$micrositio->estado			= $estado;
				if( !$micrositio->save(false) ) $transaccion->rollback();

				$pagina = Pagina::model()->findByAttributes(array('micrositio_id' => $micrositio->id));
				$pagina->nombre			= $documentalesForm->nombre;
				$pagina->destacado		= $documentalesForm->destacado;
				$pagina->estado			= $estado;
				if( !$pagina->save(false) ) $transaccion->rollback();

				$pgD = PgDocumental::model()->findByAttributes( array('pagina_id' => $pagina->id) );
				$pgD->titulo 		= $documentalesForm->nombre;
				$pgD->duracion 		= $documentalesForm->duracion;
				$pgD->anio 			= $documentalesForm->anio;
				$pgD->sinopsis 		= $documentalesForm->sinopsis;
				$pgD->estado 		= $documentalesForm->estado;
				if( !$pgD->save(false) )
					$transaccion->rollback();
				else
				{
					$transaccion->commit();
					Yii::app()->user->setFlash('mensaje', 'Documental ' . $documentalesForm->nombre . ' guardado con éxito');
					$this->redirect(array('view','id' => $documentalesForm->id));
				}

			}//if($novedadesForm->validate())

		} //if(isset($_POST['NovedadesForm']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$documentalesForm->nombre = $micrositio->nombre;
		$documentalesForm->sinopsis = $pagina->pgDocumentals->sinopsis;
		$documentalesForm->duracion = $pagina->pgDocumentals->duracion;
		$documentalesForm->anio = $pagina->pgDocumentals->anio;
		$documentalesForm->imagen = $micrositio->background;
		$documentalesForm->imagen_mobile = $micrositio->background_mobile;
		$documentalesForm->miniatura = $micrositio->miniatura;
		$documentalesForm->estado = $pagina->pgDocumentals->estado;
		$documentalesForm->destacado = $micrositio->destacado;

		$this->render('modificar',array(
			'model'=>$documentalesForm,
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

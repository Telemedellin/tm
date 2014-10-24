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
				'actions'=>array('index','view', 'imagen', 'imagen_mobile', 'miniatura', 'crear','update', 'delete', 'desasignarmenu'),
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
		
		$model = new Micrositio('search');
		$model->seccion_id = 4;
		
		if(isset($_GET['Micrositio']))
			$model->attributes = $_GET['Micrositio'];

		$this->render('index', array(
			'model'=>$model,
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		if(isset($_POST['asignar_menu']))
		{
			$this->asignar_menu($id, $_POST['Micrositio']['menu_id']);
		}
		$model = Micrositio::model()->with('url', 'pagina', 'menu')->findByPk($id);
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

		$fotos = new CActiveDataProvider( 'AlbumFoto', array(
													    'criteria'=>array(
													        'condition'=>'micrositio_id = '.$id,
													        'with'=>array('fotos', 'url'),
													    )) );


		$paginas = new CActiveDataProvider( 'Pagina', array(
													    'criteria'=>array(
													        'condition'=>'micrositio_id=' . $id . ' AND tipo_pagina_id=4',
													        'with'=>array('pgDocumentals', 'url'),
													    )) );

		$paginas = new Pagina('search');
		$paginas->micrositio_id = $id;
		//$paginas->tipo_pagina_id = 4;
		if(isset($_GET['Pagina']))
			$paginas->attributes = $_GET['Pagina'];

		if($model->menu):
			$menu = new CActiveDataProvider( 'MenuItem', array(
													    'criteria'=>array(
													        'condition'=>'menu_id=' . $model->menu->id,
													        'with'=>array('urlx'),
													    )) );
		else:
			$menu = false;
		endif;

		$this->render('ver', array(
			'model' => $model,
			'contenido' => $contenido,
			'ficha_tecnica' => $ficha_tecnica,
			'videos' => $videos, 
			'fotos' => $fotos, 
			'paginas' => $paginas, 
			'menu' => $menu,
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
		$micrositio->delete();
			
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : '../');
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
				
				$micrositio 				= new Micrositio;
				$transaccion 				= $micrositio->dbConnection->beginTransaction();
				$micrositio->seccion_id 	= 4; //Documentales
				$micrositio->usuario_id 	= 1;
				$micrositio->nombre			= $documentalesForm->nombre;
				$micrositio->background 	= $dird . $documentalesForm->imagen;
				$micrositio->background_mobile 	= $dird . $documentalesForm->imagen_mobile;
				$micrositio->miniatura 		= $dird . $documentalesForm->miniatura;
				$micrositio->destacado		= $documentalesForm->destacado;
				
				$micrositio->estado			= $documentalesForm->estado;
				if( !$micrositio->save(false) ) $transaccion->rollback();
				$micrositio_id = $micrositio->getPrimaryKey();

				$pagina = new Pagina;
				$pagina->micrositio_id 		= $micrositio_id;
				$pagina->tipo_pagina_id 	= 1; //Página programa
				$pagina->nombre				= $documentalesForm->nombre;
				$pagina->meta_descripcion 	= $documentalesForm->meta_descripcion;
				$pagina->clase 				= NULL;
				$pagina->destacado			= $documentalesForm->destacado;
				$pagina->estado			  	= ($documentalesForm->estado == 2)?1:$documentalesForm->estado;
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
					Yii::app()->user->setFlash('success', 'Documental ' . $documentalesForm->nombre . ' guardado con éxito');
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
				$micrositio = Micrositio::model()->findByPk($id);
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
				
				$micrositio->estado			= $documentalesForm->estado;
				$micrositio->save();

				$pagina = Pagina::model()->findByAttributes(array('micrositio_id' => $micrositio->id));
				$pagina->nombre				= $documentalesForm->nombre;
				$pagina->meta_descripcion 	= $documentalesForm->meta_descripcion;
				$pagina->destacado			= $documentalesForm->destacado;
				$pagina->estado			  	= ($documentalesForm->estado == 2)?1:$documentalesForm->estado;
				$pagina->save();

				$pgD = PgDocumental::model()->findByAttributes( array('pagina_id' => $pagina->id) );
				$pgD->titulo 		= $documentalesForm->nombre;
				$pgD->duracion 		= $documentalesForm->duracion;
				$pgD->anio 			= $documentalesForm->anio;
				$pgD->sinopsis 		= $documentalesForm->sinopsis;
				$pgD->estado 		= $documentalesForm->estado;
				if( $pgD->save() )
				{
					Yii::app()->user->setFlash('success', 'Documental ' . $documentalesForm->nombre . ' guardado con éxito');
					$this->redirect(array('view','id' => $documentalesForm->id));
				}else
				{
					Yii::app()->user->setFlash('warning', 'Documental ' . $documentalesForm->nombre . ' no se pudo guardar');
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
		$documentalesForm->meta_descripcion = $pagina->meta_descripcion;
		$documentalesForm->estado = $pagina->pgDocumentals->estado;
		$documentalesForm->destacado = $micrositio->destacado;

		$this->render('modificar',array(
			'model'=>$documentalesForm,
		));
	}

	public function actionDesasignarmenu($id)
	{
		$m = Micrositio::model()->findByPk($id);
		$m->menu_id = NULL;
		$m->save();
		$this->redirect( array('view', 'id' => $id . '#menu'));
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

	protected function asignar_menu($id, $menu_id)
	{
		$m = Micrositio::model()->findByPk($id);
		$m->menu_id = $menu_id;
		if($m->save()) return true;
		else return false;
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

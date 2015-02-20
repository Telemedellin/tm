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
				'actions'=>array('index','view', 'imagen', 'imagen_mobile', 'miniatura', 'crear','update', 'delete', 'banners', 'crearbanner', 'viewbanner', 'updatebanner', 'deletebanner', 'imagen_banner', 'imagen_mobile_banner'),
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
                'directorio' => 'images/novedades/' . date('Y') . '/' . date('m') . '/',
                'param_name' => 'archivoImagen'
            ),
            'imagen_mobile'=>array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/novedades/' . date('Y') . '/' . date('m') . '/',
                'param_name' => 'archivoImagenMobile'
            ),
            'miniatura'=> array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/novedades/' . date('Y') . '/' . date('m') . '/thumbnail/',
                'param_name' => 'archivoMiniatura',
                'image_versions' => 
					array(
						'' => array('max_width' => 90, 'max_height' => 60, 'jpeg_quality' => 100)
					)
            ),
            'imagen_banner'=>array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/novedades/banners/' . date('Y') . '/' . date('m') . '/',
                'param_name' => 'archivoImagen', 
                'image_versions' => 
					array(
						'' => array('max_width' => 390, 'max_height' => 150, 'jpeg_quality' => 100)
					)
            ),
            'imagen_mobile_banner'=>array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/novedades/banners/' . date('Y') . '/' . date('m') . '/',
                'param_name' => 'archivoImagenMobile', 
                'image_versions' => 
					array(
						'' => array('max_width' => 650, 'max_height' => 400, 'jpeg_quality' => 100)
					)
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
		Yii::app()->session->remove('dir');
		Yii::app()->session->remove('dirc');
		
		$model = new Pagina('search');
		$model->tipo_pagina_id = 3;
		$model->micrositio_id = 2;
		
		if(isset($_GET['Pagina']))
			$model->attributes = $_GET['Pagina'];

		$this->render('index', array(
			'model' => $model, 
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
		$pagina = Pagina::model()->findByPk($id);
		$pagina->delete();

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
		if( !isset(Yii::app()->session['dir']) ) Yii::app()->session['dir'] = 'novedades/' . date('Y') . '/' . date('m') . '/';

		$novedadesForm = new NovedadesForm;

		if(isset($_POST['NovedadesForm'])){
			$novedadesForm->attributes = $_POST['NovedadesForm'];
			if( isset(Yii::app()->session['dir']) ){
				$dir = Yii::app()->session['dir'];
			}
			if($novedadesForm->validate()){
				
				$pagina 				= new Pagina;
				$transaccion 			= $pagina->dbConnection->beginTransaction();
				$pagina->micrositio_id 	= 2; //Novedades
				$pagina->tipo_pagina_id = 3; //Novedad
				$pagina->nombre			= $novedadesForm->nombre;
				$pagina->background 		= $dir . $novedadesForm->imagen;
				$pagina->background_mobile 	= $dir . $novedadesForm->imagen_mobile;
				$pagina->miniatura 		= $dir . $novedadesForm->miniatura;
				$pagina->clase 			= NULL;
				$pagina->estado 		= $novedadesForm->estado;
				$pagina->destacado		= $novedadesForm->destacado;
				if( !$pagina->save(false) ) $transaccion->rollback();
				$pagina_id = $pagina->getPrimaryKey();

				$pgAB = new PgArticuloBlog;
				$pgAB->pagina_id 	= $pagina_id;
				$pgAB->entradilla 	= $novedadesForm->entradilla;
				$pgAB->texto 		= $novedadesForm->texto;
				$pgAB->enlace 		= $novedadesForm->enlace;
				$pgAB->comentarios 	= $novedadesForm->comentarios;
				$pgAB->posicion 	= $novedadesForm->posicion;
				$pgAB->estado 		= ($novedadesForm->estado)?1:0;
				
				if( !$pgAB->save(false) )
					$transaccion->rollback();
				else
				{
					$transaccion->commit();
					Yii::app()->user->setFlash('success', 'Novedad ' . $novedadesForm->nombre . ' guardada con éxito');
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

		if(isset($_POST['NovedadesForm'])){
			$novedadesForm->attributes = $_POST['NovedadesForm'];
			if( isset(Yii::app()->session['dir']) ){
				$dir = Yii::app()->session['dir'];
			}
			if($novedadesForm->validate()){
				$pagina = Pagina::model()->findByPk($id);
				$transaccion 	= $pagina->dbConnection->beginTransaction();

				$pagina->nombre			= $novedadesForm->nombre;

				if($novedadesForm->imagen != $pagina->background)
				{
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $pagina->background);
					$pagina->background 	= $dir . $novedadesForm->imagen;
				}
				if($novedadesForm->imagen_mobile != $pagina->background_mobile)
				{
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $pagina->background_mobile);
					$pagina->background_mobile 	= $dir . $novedadesForm->imagen_mobile;
				}
				if($novedadesForm->miniatura != $pagina->miniatura)
				{
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $pagina->miniatura);
					$pagina->miniatura 	= $dir . $novedadesForm->miniatura;
				}

				$pagina->destacado		= $novedadesForm->destacado;
				$pagina->estado			= $novedadesForm->estado;

				if( !$pagina->save(false) ) $transaccion->rollback();
				$pagina_id = $pagina->id;

				$pgAB = PgArticuloBlog::model()->findByAttributes(array('pagina_id' => $pagina_id));
				$pgAB->entradilla 	= $novedadesForm->entradilla;
				$pgAB->texto 		= $novedadesForm->texto;
				$pgAB->enlace 		= $novedadesForm->enlace;
				$pgAB->posicion 	= $novedadesForm->posicion;
				$pgAB->comentarios 	= $novedadesForm->comentarios;
				$pgAB->estado 		= ($novedadesForm->estado)?1:0;
				
				if( !$pgAB->save(false) )
					$transaccion->rollback();
				else
				{
					$transaccion->commit();
					Yii::app()->user->setFlash('success', 'Novedad ' . $novedadesForm->nombre . ' modificada con éxito');
					$this->redirect(array('view','id' => $novedadesForm->id));
				}
				

			}//if($novedadesForm->validate())

		} //if(isset($_POST['NovedadesForm']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$novedadesForm->nombre = $pagina->nombre;
		$novedadesForm->entradilla = $pagina->pgArticuloBlogs->entradilla;
		$novedadesForm->texto = $pagina->pgArticuloBlogs->texto;
		$novedadesForm->enlace = $pagina->pgArticuloBlogs->enlace;
		$novedadesForm->imagen = $pagina->pgArticuloBlogs->imagen;
		$novedadesForm->imagen_mobile = $pagina->pgArticuloBlogs->imagen_mobile;
		$novedadesForm->miniatura = $pagina->pgArticuloBlogs->miniatura;
		$novedadesForm->posicion = $pagina->pgArticuloBlogs->posicion;
		$novedadesForm->comentarios = $pagina->pgArticuloBlogs->comentarios;
		$novedadesForm->estado = $pagina->estado;
		$novedadesForm->destacado = $pagina->destacado;

		$this->render('modificar',array(
			'model'=>$novedadesForm,
		));
	}

	public function actionBanners()
	{
		Yii::app()->session->remove('bn');
		
		$model = new Banner('search');
				
		if(isset($_GET['Banner']))
			$model->attributes = $_GET['Banner'];

		$this->render('banners', array(
			'model' => $model, 
		));
	}

	public function actionCrearbanner()
	{
		if( !isset(Yii::app()->session['bn']) ) Yii::app()->session['bn'] = 'novedades/banners/' . date('Y') . '/' . date('m') . '/';

		$banner = new Banner;

		if(isset($_POST['Banner'])){
			$banner->attributes = $_POST['Banner'];
			if( isset(Yii::app()->session['bn']) ){
				$bn = Yii::app()->session['bn'];
			}
			$banner->imagen 		= ($_POST['Banner']['imagen'] != '')?$bn . $_POST['Banner']['imagen']:NULL;
			$banner->imagen_mobile 	= ($_POST['Banner']['imagen_mobile'] != '')?$bn . $_POST['Banner']['imagen_mobile']:NULL;
			if(empty($_POST['Banner']['fin_contador']) || $_POST['Banner']['fin_contador'] == '0000-00-00 00:00:00') $banner->fin_contador = NULL;
			if(empty($_POST['Banner']['inicio_publicacion']) || $_POST['Banner']['inicio_publicacion'] == '0000-00-00 00:00:00') $banner->inicio_publicacion = NULL;
			if(empty($_POST['Banner']['fin_publicacion']) || $_POST['Banner']['fin_publicacion'] == '0000-00-00 00:00:00') $banner->fin_publicacion = NULL;
			if($banner->save()){
				Yii::app()->user->setFlash('success', 'Banner ' . $banner->nombre . ' guardado con éxito');
				$this->redirect( array('viewbanner', 'id' => $banner->getPrimaryKey()));
			}//if($banner->save())

		} //if(isset($_POST['Banner']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$this->render('crearBanner',array(
			'model'=>$banner,
		));
	}

	public function actionUpdatebanner($id)
	{
		if( !isset(Yii::app()->session['bn']) ) Yii::app()->session['bn'] = 'novedades/banners/' . date('Y') . '/' . date('m') . '/';

		$banner = Banner::model()->findByPk($id);

		if(isset($_POST['Banner'])){
			if( isset(Yii::app()->session['bn']) ){
				$bn = Yii::app()->session['bn'];
			}
			if($banner->imagen != $_POST['Banner']['imagen'])
			{
				@unlink( Yii::getPathOfAlias('webroot').'/images/' . $banner->imagen);
				$imagen = ($_POST['Banner']['imagen'] != '')?$bn . $_POST['Banner']['imagen']:NULL;
			}
			if($_POST['Banner']['imagen_mobile'] != $banner->imagen_mobile)
			{
				@unlink( Yii::getPathOfAlias('webroot').'/images/' . $banner->imagen_mobile);
				$imagen_mobile 	= ($_POST['Banner']['imagen_mobile'] != '')?$bn . $_POST['Banner']['imagen_mobile']:NULL;
			}
			$banner->attributes = $_POST['Banner'];
			if(isset($imagen)) $banner->imagen 		= $imagen;
			if(isset($imagen_mobile)) $banner->imagen_mobile 	= $imagen_mobile;
			if(empty($_POST['Banner']['fin_contador']) || $_POST['Banner']['fin_contador'] == '0000-00-00 00:00:00') $banner->fin_contador = NULL;
			if(empty($_POST['Banner']['inicio_publicacion']) || $_POST['Banner']['inicio_publicacion'] == '0000-00-00 00:00:00') $banner->inicio_publicacion = NULL;
			if(empty($_POST['Banner']['fin_publicacion']) || $_POST['Banner']['fin_publicacion'] == '0000-00-00 00:00:00') $banner->fin_publicacion = NULL;
			if($banner->save()){
				Yii::app()->user->setFlash('success', 'Banner ' . $banner->nombre . ' guardado con éxito');
				$this->redirect( array('viewbanner', 'id' => $banner->getPrimaryKey()));
			}//if($banner->save())

		} //if(isset($_POST['Banner']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$this->render('updateBanner',array(
			'model'=>$banner,
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionViewbanner($id)
	{
		$model = Banner::model()->findByPk($id);
		
		$this->render('verBanner', array('model' => $model));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDeletebanner($id)
	{
		$banner = Banner::model()->findByPk($id);
		$banner->delete();

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

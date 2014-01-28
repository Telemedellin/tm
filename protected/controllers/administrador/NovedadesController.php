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
				'actions'=>array('index','view', 'imagen', 'miniatura', 'crear','update', 'delete'),
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
            'miniatura'=> array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/novedades/' . date('Y') . '/' . date('m') . '/thumbnail/',
                'param_name' => 'archivoMiniatura',
                'image_versions' => 
					array(
						'' => array('max_width' => 90, 'max_height' => 60, 'jpeg_quality' => 100)
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
		Yii::app()->session->remove('dir');
		Yii::app()->session->remove('dirc');
		$dataProvider = new CActiveDataProvider('Pagina', 
													array(
													    'criteria'=>array(
													        'condition'=>'tipo_pagina_id = 3',
													        'order'=>'creado DESC',
													        /*'with'=>array('author'),*/
													    ),
													    'pagination'=>array(
													    	'pageSize'=>25,
													    ),
													) 
												);
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
		$pgAB = PgArticuloBlog::model()->findByAttributes(array('pagina_id' => $id));
		$imagen = $pgAB->imagen;
		$miniatura = $pgAB->miniatura;
		$transaccion = $pgAB->dbConnection->beginTransaction();
		if( $pgAB->delete() )
		{
			//Borrar Página
			$pagina = Pagina::model()->findByPk($id);
			$nombre = $pagina->nombre;
			$url_id = $pagina->url_id;
			if( $pagina->delete() ){
				//Borrar Url
				$url = Url::model()->findByPk($url_id);
				if($url->delete()){
					$transaccion->commit();
					//Borrar Archivos
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $miniatura);
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $imagen);
					Yii::app()->user->setFlash('mensaje', 'Novedad ' . $nombre . ' eliminada');
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
				$url = new Url;
				$transaccion 	= $url->dbConnection->beginTransaction();
				$slug = 'novedades/' . $this->slugger($novedadesForm->nombre);
				$slug = $this->verificarSlug($slug);
				$url->slug 		= $slug;
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
				$pagina->estado 		= $novedadesForm->estado;
				$pagina->destacado		= $novedadesForm->destacado;
				if( !$pagina->save(false) ) $transaccion->rollback();
				$pagina_id = $pagina->getPrimaryKey();

				$pgAB = new PgArticuloBlog;
				$pgAB->pagina_id 	= $pagina_id;
				$pgAB->entradilla 	= $novedadesForm->entradilla;
				$pgAB->texto 		= $novedadesForm->texto;
				$pgAB->enlace 		= $novedadesForm->enlace;
				$pgAB->imagen 		= $dir . $novedadesForm->imagen;
				$pgAB->posicion 	= $novedadesForm->posicion;
				$pgAB->miniatura 	= $dir . $novedadesForm->miniatura;
				$pgAB->estado 		= $novedadesForm->estado;
				
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
				if($novedadesForm->nombre != $pagina->nombre){
					$url = Url::model()->findByPk($pagina->url_id);
					$slug = 'novedades/' . $this->slugger($novedadesForm->nombre);
					$slug = $this->verificarSlug($slug);
					$url->slug 		= $slug;
					$url->save(false);
				}
				
				$pagina = Pagina::model()->findByPk($id);
				$transaccion 	= $pagina->dbConnection->beginTransaction();

				$pagina->nombre			= $novedadesForm->nombre;
				$pagina->destacado		= $novedadesForm->destacado;
				$pagina->estado			= $novedadesForm->estado;
				if( !$pagina->save(false) ) $transaccion->rollback();
				$pagina_id = $pagina->id;

				$pgAB = PgArticuloBlog::model()->findByAttributes(array('pagina_id' => $pagina_id));

				if($novedadesForm->imagen != $pgAB->imagen)
				{
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $pgAB->imagen);
					$pgAB->imagen 	= $dir . $novedadesForm->imagen;
				}
				if($novedadesForm->miniatura != $pgAB->miniatura)
				{
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $pgAB->miniatura);
					$pgAB->miniatura 	= $dir . $novedadesForm->miniatura;
				}

				$pgAB->entradilla 	= $novedadesForm->entradilla;
				$pgAB->texto 		= $novedadesForm->texto;
				$pgAB->enlace 		= $novedadesForm->enlace;
				$pgAB->posicion 	= $novedadesForm->posicion;
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
		$novedadesForm->nombre = $pagina->nombre;
		$novedadesForm->entradilla = $pagina->pgArticuloBlogs->entradilla;
		$novedadesForm->texto = $pagina->pgArticuloBlogs->texto;
		$novedadesForm->enlace = $pagina->pgArticuloBlogs->enlace;
		$novedadesForm->imagen = $pagina->pgArticuloBlogs->imagen;
		$novedadesForm->miniatura = $pagina->pgArticuloBlogs->miniatura;
		$novedadesForm->posicion = $pagina->pgArticuloBlogs->posicion;
		$novedadesForm->estado = $pagina->estado;
		$novedadesForm->destacado = $pagina->destacado;

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

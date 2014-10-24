<?php

class EspecialesController extends Controller
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
				'actions'=>array('index', 'view', 'imagen', 'imagen_mobile', 'miniatura', 'crear', 'update', 'delete', 'desasignarmenu'),
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
                'directorio' => 'images/backgrounds/especiales/',
                'param_name' => 'archivoImagen'
            ),
            'imagen_mobile'=>array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/backgrounds/especiales/',
                'param_name' => 'archivoImagenMobile'
            ),
            'miniatura'=> array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/backgrounds/especiales/thumbnail/',
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
		Yii::app()->session->remove('dire');
		
		$model = new Micrositio('search');
		$model->seccion_id = 3;
		
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
		$contenido = PgBloques::model()->findByAttributes(array('pagina_id' => $model->pagina->id));
		/*$fechas = new CActiveDataProvider( 'FechaEspecial', array(
													    'criteria'=>array(
													        'condition'=>'pg_especial_id = '.$contenido->id
													    ),
													    'pagination'=>array(
													    	'pageSize'=>25,
													    )) );*/
		/*$bloques = new CActiveDataProvider( 'Bloque', array(
													    'criteria'=>array(
													        'condition'=>'pg_bloques_id = '.$contenido->id
													    )) );/**/
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

		$paginas = new Pagina('search');
		$paginas->micrositio_id = $id;
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
			//'bloques' => $bloques,
			//'fechas' => $fechas,
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
		if( !isset(Yii::app()->session['dire']) ) Yii::app()->session['dire'] = 'backgrounds/especiales/';

		$especialesForm = new EspecialesForm;		

		if(isset($_POST['EspecialesForm'])){
			$especialesForm->attributes = $_POST['EspecialesForm'];
			if( isset(Yii::app()->session['dire']) ){
				$dire = Yii::app()->session['dire'];
			}
			if($especialesForm->validate()){
				
				$micrositio 				= new Micrositio;
				$transaccion 				= $micrositio->dbConnection->beginTransaction();
				$micrositio->seccion_id 	= 3; //Especiales
				$micrositio->usuario_id 	= 1;
				$micrositio->nombre			= $especialesForm->nombre;
				$micrositio->background 	= ($especialesForm->imagen)?$dire . $especialesForm->imagen:NULL;
				$micrositio->background_mobile 	= ($especialesForm->imagen_mobile)?$dire . $especialesForm->imagen_mobile:NULL;
				$micrositio->miniatura 		= ($especialesForm->miniatura)?$dire . $especialesForm->miniatura:NULL;
				$micrositio->destacado		= $especialesForm->destacado;
				$micrositio->estado			= $especialesForm->estado;
				if( !$micrositio->save(false) ) $transaccion->rollback();
				$micrositio_id = $micrositio->getPrimaryKey();

				$pagina = new Pagina;
				$pagina->micrositio_id 		= $micrositio_id;
				$pagina->tipo_pagina_id 	= 10; //Página bloques
				$pagina->nombre				= $especialesForm->nombre;
				$pagina->meta_descripcion 	= $especialesForm->meta_descripcion;
				$pagina->clase 				= NULL;
				$pagina->destacado			= $especialesForm->destacado;
				$pagina->estado			  	= ($especialesForm->estado == 2)?1:$especialesForm->estado;
				if( !$pagina->save(false) ) $transaccion->rollback();
				$pagina_id = $pagina->getPrimaryKey();

				$micrositio->pagina_id = $pagina_id;

				if( !$micrositio->save(false) ) $transaccion->rollback();

				$pgB = new PgBloques;
				$pgB->pagina_id 	= $pagina_id;
				$pgB->estado 		= $especialesForm->estado;
				
				if( !$pgB->save(false) )
					$transaccion->rollback();
				else
				{
					$transaccion->commit();
					Yii::app()->user->setFlash('success', 'Especial ' . $especialesForm->nombre . ' guardado con éxito');
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : '../');
				}

			}//if($novedadesForm->validate())

		} //if(isset($_POST['NovedadesForm']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		
		$this->render('crear',array(
			'model'=>$especialesForm,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{

		if( !isset(Yii::app()->session['dire']) ) Yii::app()->session['dire'] = 'backgrounds/especiales/';

		$micrositio = Micrositio::model()->with('url', 'pagina')->findByPk($id);
		$pagina = Pagina::model()->with('url')->findByAttributes(array('micrositio_id' => $micrositio->id));

		$especialesForm = new EspecialesForm;		
		$especialesForm->id = $id;

		if(isset($_POST['EspecialesForm'])){
			$especialesForm->attributes = $_POST['EspecialesForm'];
			if( isset(Yii::app()->session['dire']) ){
				$dire = Yii::app()->session['dire'];
			}
			if($especialesForm->validate()){
				$micrositio = Micrositio::model()->findByPk($id);
				$micrositio->nombre			= $especialesForm->nombre;
				if($especialesForm->imagen != $micrositio->background)
				{
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $micrositio->background);
					$micrositio->background 	= $dire . $especialesForm->imagen;
				}
				if($especialesForm->imagen_mobile != $micrositio->background_mobile)
				{
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $micrositio->background_mobile);
					$micrositio->background_mobile 	= $dire . $especialesForm->imagen_mobile;
				}
				if($especialesForm->miniatura != $micrositio->miniatura)
				{
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $micrositio->miniatura);
					$micrositio->miniatura 	= $dire . $especialesForm->miniatura;
				}

				$micrositio->destacado		= $especialesForm->destacado;
				
				$micrositio->estado			= $especialesForm->estado;
				$micrositio->save();

				$pagina = Pagina::model()->findByAttributes(array('micrositio_id' => $micrositio->id));
				$pagina->nombre				= $especialesForm->nombre;
				$pagina->meta_descripcion 	= $especialesForm->meta_descripcion;
				$pagina->destacado			= $especialesForm->destacado;
				$pagina->estado			  	= ($especialesForm->estado == 2)?1:$especialesForm->estado;

				$pagina->save();

				$pgB = PgBloques::model()->findByAttributes( array('pagina_id' => $pagina->id) );
				if(!$pgB) $pgB = PgGenericaSt::model()->findByAttributes( array('pagina_id' => $pagina->id) );
				$pgB->estado 		= $especialesForm->estado;
				if( $pgB->save() )
				{
					Yii::app()->user->setFlash('success', 'Especial ' . $especialesForm->nombre . ' guardado con éxito');
					$this->redirect(array('view','id' => $especialesForm->id));
				}else
				{
					Yii::app()->user->setFlash('warning', 'Especial ' . $especialesForm->nombre . ' no se pudo guardar');
				}

			}//if($novedadesForm->validate())

		} //if(isset($_POST['NovedadesForm']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$especialesForm->nombre = $micrositio->nombre;
		$especialesForm->imagen = $micrositio->background;
		$especialesForm->imagen_mobile = $micrositio->background_mobile;
		$especialesForm->miniatura = $micrositio->miniatura;
		$especialesForm->meta_descripcion = $pagina->meta_descripcion;
		$especialesForm->estado = $micrositio->estado;
		$especialesForm->destacado = $micrositio->destacado;

		$this->render('modificar',array(
			'model'=>$especialesForm,
		));
	}

	public function actionDesasignarmenu($id)
	{
		$m = Micrositio::model()->findByPk($id);
		$m->menu_id = NULL;
		$m->save();
		$this->redirect(array('view', 'id' => $id . '#menu'));
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

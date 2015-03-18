<?php

class DocumentalesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/administrador';
	private $image_folder;

	protected function beforeAction($action) 
	{
		$this->image_folder = DocumentalesForm::getImageRoute();
		
		Yii::app()->session->remove('dir');
		if( !isset(Yii::app()->session['dir']) ) Yii::app()->session['dir'] = $this->image_folder;
		return parent::beforeAction($action);
	}

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
                'directorio' => 'images/backgrounds/documentales/' . date('Y') . '/',
                'param_name' => 'archivoImagen'
            ),
            'imagen_mobile'=>array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/backgrounds/documentales/' . date('Y') . '/',
                'param_name' => 'archivoImagenMobile'
            ),
            'miniatura'=> array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/backgrounds/documentales/' . date('Y') . '/thumbnail/',
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

		$generos = new CActiveDataProvider( 'MicrositioXGenero', array(
													    'criteria'=>array(
													        'condition'=>'micrositio_id = '.$id,
													        'with'=>array('genero'),
													    )) );

		$relacionados = new CActiveDataProvider( 'MicrositioXRelacionado', array(
													    'criteria'=>array(
													        'condition'=>'micrositio_id = '.$id,
													        'order' => 'orden ASC', 
													        'with'=>array('micrositio'),
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
			'generos' => $generos, 
			'relacionados' => $relacionados, 
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
		$documentalesForm = new DocumentalesForm;		

		if(isset($_POST['DocumentalesForm'])){
			$documentalesForm->attributes = $_POST['DocumentalesForm'];
		
			if($documentalesForm->guardar())
			{
				Yii::app()->user->setFlash('success', 'Documental ' . $documentalesForm->nombre . ' guardado con éxito');
				$this->redirect( array('view', 'id' => $documentalesForm->id) );
			}//if($novedadesForm->guardar())

		} //if(isset($_POST['DocumentalesForm']))

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

		$documentalesForm = new DocumentalesForm;		
		$documentalesForm->id = $id;

		if(isset($_POST['DocumentalesForm'])){
			$documentalesForm->attributes = $_POST['DocumentalesForm'];
			
			if($documentalesForm->guardar()){
				Yii::app()->user->setFlash('success', 'Documental ' . $documentalesForm->nombre . ' guardado con éxito');
				$this->redirect(array('view','id' => $documentalesForm->id));
			}else
			{
				Yii::app()->user->setFlash('warning', 'Documental ' . $documentalesForm->nombre . ' no se pudo guardar');
			}//if($novedadesForm->validate())

		} //if(isset($_POST['DocumentalesForm']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$micrositio = Micrositio::model()->with('url', 'pagina')->findByPk($id);
		$pagina = Pagina::model()->with('url', 'pgDocumentals')->findByAttributes(array('micrositio_id' => $micrositio->id));
		//$pgD = PgDocumental::model()->with('fichaTecnicas')->findByAttributes(array('pagina_id' => $pagina->id));

		$documentalesForm->set_fields($micrositio, $pagina);

		$this->render('modificar',array(
			'model'=>$documentalesForm,
		));
	}

	public function actionDesasignarmenu($id)
	{
		$m = Micrositio::model()->findByPk($id);
		$m->menu_id = NULL;
		$m->save();
		$this->redirect( array('view', 'id' => $id));
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

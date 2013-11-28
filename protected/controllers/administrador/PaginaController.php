<?php

class PaginaController extends Controller
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
				'actions'=>array('index','view', 'crear','update','delete', 'imagen', 'miniatura'),
				'users'=>array('@'),
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
                'directorio' => 'images/backgrounds/paginas/',
                'param_name' => 'archivoImagenPa'
            ),
            'miniatura'=> array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/backgrounds/paginas/thumbnail/',
                'param_name' => 'archivoMiniaturaPa',
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

	/*
	public function actions()
    {
        return array(
        	'imageList'=>array(
                'class'=>'ext.redactor.actions.ImageList',
                'uploadPath'=>Yii::app()->basePath.'/../images',
                'uploadUrl'=>bu('images'),
            ),
            'fileUpload'=> array(
            	'class' => 'ext.redactor.actions.FileUpload', 
            	'uploadPath'=>'/tm/archivos/'.date('Y').'/'.date('m'),
                'uploadUrl'=>'/tm/archivos/'.date('Y').'/'.date('m'),
                'uploadCreate'=>true,
                'permissions'=>0755,
            ),
            'imageUpload'=>array(
                'class'=>'ext.redactor.actions.ImageUpload',
                'uploadPath'=>'/tm/images/contenido/'.date('Y').'/'.date('m'),
                'uploadUrl'=>'/tm/images/contenido/'.date('Y').'/'.date('m'),
                'uploadCreate'=>true,
                'permissions'=>0755,
            ),
        );
    }*/

   	
    public function actionImagelist($attr)
    {
		$attribute=strtolower($attr);
		$uploadPath=Yii::app()->basePath.'/../images';
		$uploadUrl=bu('images');

		if ($uploadPath===null) {
			$path=Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'uploads';
			$uploadPath=realpath($path);
			if ($uploadPath===false) {
				exit;
			}
		}
		if ($uploadUrl===null) {
			$uploadUrl=Yii::app()->request->baseUrl .'/uploads';
		}

		$attributePath=$uploadPath.DIRECTORY_SEPARATOR.$attribute;
		$attributeUrl=$uploadUrl.'/'.$attribute.'/';

		$files=CFileHelper::findFiles($attributePath,array('fileTypes'=>array('gif','png','jpg','jpeg'), 'level'=>0));
		$data=array();
		if ($files) {
			foreach($files as $file) {
				$data[]=array(
					'thumb'=>$attributeUrl.basename($file),
					'image'=>$attributeUrl.basename($file),
				);
			}
		}
		echo CJSON::encode($data);
		exit;
    }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Pagina', 
													array(
														'pagination'=>array(
													    	'pageSize'=>25,
													    ),
												)
											);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$pagina = Pagina::model()->cargarPagina($id);

		$contenido = $this->renderPartial('_' . lcfirst($pagina['partial']), array('contenido' => $pagina), true);

		$this->render('ver',array(
			'model'=>$pagina['pagina'],
			'contenido'=>$contenido,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCrear($id)
	{
		if( !isset(Yii::app()->session['dirpa']) ) Yii::app()->session['dirpa'] = 'backgrounds/paginas/';
		$micrositio = ($id)?Micrositio::model()->with('seccion')->findByPk($id):0;
		$model = new Pagina;
		$model->micrositio_id = $micrositio;
		$contenido = new PgGenericaSt;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pagina']))
		{
			$model->attributes = $_POST['Pagina'];
			$m = Micrositio::model()->with('seccion')->findByPk($model->micrositio_id);
			$model->tipo_pagina_id = 2;
			$url = new Url;
			$slug = $this->slugger($m->seccion->nombre) . '/' . $this->slugger($m->nombre) . '/' . $this->slugger($model->nombre);
			$slug = $this->verificarSlug($slug);
			$url->slug 		= $slug;
			$url->tipo_id 	= 3; //Pagina
			$url->estado  	= 1;
			if( !$url->save(false) ) $transaccion->rollback();
			$url_id = $url->getPrimaryKey();
			$model->url_id = $url_id;
			if($model->save()){
				if(isset($_POST['PgGenericaSt']))
				{
					if( isset(Yii::app()->session['dirpa']) ){
						$dirpa = Yii::app()->session['dirpa'];
					}
					$contenido->pagina_id = $model->getPrimaryKey();
					$contenido->imagen 	= ($_POST['PgGenericaSt']['imagen'] != '')?$dirpa . $_POST['PgGenericaSt']['imagen']:NULL;
					$contenido->miniatura 		= ($_POST['PgGenericaSt']['miniatura'])?$dirpa . 'thumbnail/' . $_POST['PgGenericaSt']['miniatura']:NULL;
					$contenido->texto = $_POST['PgGenericaSt']['texto'];
					$contenido->estado = 1;
					if($contenido->save())
						$this->redirect(array('view','id'=>$model->id));
				}
			}
				
		}

		$this->render('crear',array(
			'model'=>$model,
			'partial' => 'PgGenericaSt',
			'contenido' => $contenido,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		if( !isset(Yii::app()->session['dirpa']) ) Yii::app()->session['dirpa'] = 'backgrounds/paginas/';
		$datos = Pagina::model()->cargarPagina($id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pagina']))
		{
			$m = Micrositio::model()->with('seccion')->findByPk($datos['pagina']->micrositio_id);

			if($datos['pagina']->nombre != $_POST['Pagina']['nombre'])
			{
				$url = Url::model()->findByPk($datos['pagina']->url_id);;
				$slug = $this->slugger($m->seccion->nombre) . '/' . $this->slugger($m->nombre) . '/' . $this->slugger($_POST['Pagina']['nombre']);
				$slug = $this->verificarSlug($slug);
				$url->slug 	= $slug;
				$url->save();
			}			

			$datos['pagina']->attributes = $_POST['Pagina'];

			if($datos['pagina']->save())
			{
				if(isset($_POST['PgGenericaSt']))
				{
					$contenido = PgGenericaSt::model()->findByPk($_POST['PgGenericaSt']['id']);
					if( isset(Yii::app()->session['dirpa']) ){
						$dirpa = Yii::app()->session['dirpa'];
					}
					if($_POST['PgGenericaSt']['imagen'] != $contenido->imagen)
					{
						@unlink( Yii::getPathOfAlias('webroot').'/images/' . $contenido->imagen);
						$contenido->imagen 	= ($_POST['PgGenericaSt']['imagen'] != '')?$dirpa . $_POST['PgGenericaSt']['imagen']:NULL;
					}
					if($_POST['PgGenericaSt']['miniatura'] != $contenido->miniatura)
					{
						@unlink( Yii::getPathOfAlias('webroot').'/images/' . $contenido->miniatura);
						$contenido->miniatura 	= ($_POST['PgGenericaSt']['miniatura'] != '')?$dirpa . $_POST['PgGenericaSt']['miniatura']:NULL;
					}
					$contenido->texto = $_POST['PgGenericaSt']['texto'];
					if($contenido->save())
						$this->redirect(array('view', 'id'=>$datos['pagina']->id));
				}
			}
		}else
		{
			$contenido = new PgGenericaSt;
			$contenido = $datos['contenido'];
		}

		$this->render('update',array(
			'model'=> $datos['pagina'],
			'partial' => $datos['partial'],
			'contenido' => $contenido,
		));
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$pagina = $this->loadModel($id);
		$tabla 	= $pagina->tipoPagina->tabla;
		$t 		= new $tabla();
		$contenido = $t->findByAttributes( array('pagina_id' => $id) );
		$contenido->delete();
		$pagina->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Pagina the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Pagina::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Pagina $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pagina-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

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
				'actions'=>array('index','view', 'crear','update','delete', 'imagen', 'imagen_mobile', 'miniatura'),
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
                'param_name' => 'archivoImagen'
            ),
            'imagen_mobile'=>array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/backgrounds/paginas/',
                'param_name' => 'archivoImagenMobile'
            ),
            'miniatura'=> array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/backgrounds/paginas/thumbnail/',
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

		if( lcfirst($pagina['partial']) == 'carpeta' )
		{
			$ca = Carpeta::model()->with('carpetas', 'archivos', 'url')->findAllByAttributes( array('pagina_id' => $id, 'item_id' => 0) );
			$contenido = $this->renderPartial('_carpeta', array('contenido' => $pagina, 'carpeta' => $ca, 'model' => $pagina['pagina']), true);
		}
		else
		{
			if($pagina['pagina']->tipo_pagina_id == 8)
			{
				$fi = new CActiveDataProvider('FiltroItem', array(
				    'criteria'=>array(
				        'condition'=>'pg_filtro_id='.$pagina['contenido']->id
				    ),
				    'pagination'=>array(
				        'pageSize'=>50,
				    ),
				));
				$pagina['contenido']['filtroItems'] = $fi;
			}
			$contenido = $this->renderPartial('_' . lcfirst($pagina['partial']), array('contenido' => $pagina), true);
		}
		
		$this->render('ver',array(
			'model'=>$pagina['pagina'],
			'contenido'=>$contenido,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCrear($id, $tipo_pagina_id = 2)
	{
		if( !isset(Yii::app()->session['dirpa']) ) Yii::app()->session['dirpa'] = 'backgrounds/paginas/';
		$micrositio = ($id)?Micrositio::model()->with('seccion')->findByPk($id):0;
		$model = new Pagina;
		$model->micrositio_id = $micrositio;
		switch($tipo_pagina_id)
		{
			case 2:
				$ppc = 'PgGenericaSt';
				break;
			case 4:
				$ppc = 'PgDocumental';
				break;
			case 8:
				$ppc = 'PgFiltro';
				break;
			default: 
				$ppc = 'PgGenericaSt';
		}
		$contenido = new $ppc;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pagina']))
		{
			$model->attributes = $_POST['Pagina'];
			$m = Micrositio::model()->with('seccion')->findByPk($model->micrositio_id);
			$model->tipo_pagina_id = $tipo_pagina_id;
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
				if( isset(Yii::app()->session['dirpa']) ){
					$dirpa = Yii::app()->session['dirpa'];
				}
				if(isset($_POST['PgGenericaSt']))
				{
					$contenido->imagen 	= ($_POST['PgGenericaSt']['imagen'] != '')?$dirpa . $_POST['PgGenericaSt']['imagen']:NULL;
					$contenido->imagen_mobile 	= ($_POST['PgGenericaSt']['imagen_mobile'] != '')?$dirpa . $_POST['PgGenericaSt']['imagen_mobile']:NULL;
					$contenido->miniatura 		= ($_POST['PgGenericaSt']['miniatura'])?$dirpa . 'thumbnail/' . $_POST['PgGenericaSt']['miniatura']:NULL;
					$contenido->texto = $_POST['PgGenericaSt']['texto'];
				}
				if(isset($_POST['PgDocumental']))
				{
					$contenido = PgDocumental::model()->findByPk($_POST['PgDocumental']['id']);
					$contenido->titulo 	 = $_POST['PgDocumental']['titulo'];
					$contenido->duracion = $_POST['PgDocumental']['duracion'];
					$contenido->anio 	 = $_POST['PgDocumental']['anio'];
					$contenido->sinopsis = $_POST['PgDocumental']['sinopsis'];
				}
				if(isset($_POST['PgFiltro']))
				{
					$contenido->imagen 	= ($_POST['PgFiltro']['imagen'] != '')?$dirpa . $_POST['PgFiltro']['imagen']:NULL;
					$contenido->imagen_mobile = ($_POST['PgFiltro']['imagen_mobile'] != '')?$dirpa . $_POST['PgFiltro']['imagen_mobile']:NULL;
					$contenido->miniatura 	  = ($_POST['PgFiltro']['miniatura'])?$dirpa . 'thumbnail/' . $_POST['PgFiltro']['miniatura']:NULL;
					$contenido->descripcion   = $_POST['PgFiltro']['descripcion'];
				}
				$contenido->estado = 1;
				$contenido->pagina_id = $model->getPrimaryKey();
				if($contenido->save())
					$this->redirect(array('view','id'=>$model->id));
			}
			
		}

		$this->render('crear',array(
			'model'=>$model,
			'partial' => $ppc,
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
				if( isset(Yii::app()->session['dirpa']) ){
					$dirpa = Yii::app()->session['dirpa'];
				}
				if(isset($_POST['PgGenericaSt']))
				{
					$contenido = PgGenericaSt::model()->findByPk($_POST['PgGenericaSt']['id']);
					
					if($_POST['PgGenericaSt']['imagen'] != $contenido->imagen)
					{
						@unlink( Yii::getPathOfAlias('webroot').'/images/' . $contenido->imagen);
						$contenido->imagen 	= ($_POST['PgGenericaSt']['imagen'] != '')?$dirpa . $_POST['PgGenericaSt']['imagen']:NULL;
					}
					if($_POST['PgGenericaSt']['imagen_mobile'] != $contenido->imagen_mobile)
					{
						@unlink( Yii::getPathOfAlias('webroot').'/images/' . $contenido->imagen_mobile);
						$contenido->imagen_mobile 	= ($_POST['PgGenericaSt']['imagen_mobile'] != '')?$dirpa . $_POST['PgGenericaSt']['imagen_mobile']:NULL;
					}
					if($_POST['PgGenericaSt']['miniatura'] != $contenido->miniatura)
					{
						@unlink( Yii::getPathOfAlias('webroot').'/images/' . $contenido->miniatura);
						$contenido->miniatura 	= ($_POST['PgGenericaSt']['miniatura'] != '')?$dirpa . $_POST['PgGenericaSt']['miniatura']:NULL;
					}
					$contenido->texto = $_POST['PgGenericaSt']['texto'];
				}
				if(isset($_POST['PgDocumental']))
				{
					$contenido = PgDocumental::model()->findByPk($_POST['PgDocumental']['id']);
					$contenido->titulo 	 = $_POST['PgDocumental']['titulo'];
					$contenido->duracion = $_POST['PgDocumental']['duracion'];
					$contenido->anio 	 = $_POST['PgDocumental']['anio'];
					$contenido->sinopsis = $_POST['PgDocumental']['sinopsis'];
				}
				if(isset($_POST['PgFiltro']))
				{
					$contenido = PgFiltro::model()->findByPk($_POST['PgFiltro']['id']);
					if($_POST['PgFiltro']['imagen'] != $contenido->imagen)
					{
						@unlink( Yii::getPathOfAlias('webroot').'/images/' . $contenido->imagen);
						$contenido->imagen 	= ($_POST['PgFiltro']['imagen'] != '')?$dirpa . $_POST['PgFiltro']['imagen']:NULL;
					}
					if($_POST['PgFiltro']['imagen_mobile'] != $contenido->imagen_mobile)
					{
						@unlink( Yii::getPathOfAlias('webroot').'/images/' . $contenido->imagen_mobile);
						$contenido->imagen_mobile 	= ($_POST['PgFiltro']['imagen_mobile'] != '')?$dirpa . $_POST['PgFiltro']['imagen_mobile']:NULL;
					}
					if($_POST['PgFiltro']['miniatura'] != $contenido->miniatura)
					{
						@unlink( Yii::getPathOfAlias('webroot').'/images/' . $contenido->miniatura);
						$contenido->miniatura 	= ($_POST['PgFiltro']['miniatura'] != '')?$dirpa . $_POST['PgFiltro']['miniatura']:NULL;
					}
					$contenido->descripcion = $_POST['PgFiltro']['descripcion'];
				}
				if($contenido->save())
					$this->redirect(array('view', 'id'=>$datos['pagina']->id));
			}
		}else
		{
			$contenido = new $datos['partial']();
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

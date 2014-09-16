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
			array('CrugeAccessControlFilter'),
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
						'' => array('max_width' => 360, 'max_height' => 360)
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
			if($pagina['pagina']->tipo_pagina_id == 10)
			{
				$bloques = new CActiveDataProvider('Bloque', array(
				    'criteria'=>array(
				        'condition'=>'pg_bloques_id='.$pagina['contenido']->id
				    ),
				    'pagination'=>array(
				        'pageSize'=>50,
				    ),
				));
				$pagina['contenido']['bloques'] = $bloques;
			}
			if($pagina['pagina']->tipo_pagina_id == 12)
			{
				$eventos = new CActiveDataProvider('Evento', array(
				    'criteria'=>array(
				        'condition'=>'pg_eventos_id='.$pagina['contenido']->id
				    ),
				    'pagination'=>array(
				        'pageSize'=>50,
				    ),
				));
				$pagina['contenido']['eventos'] = $eventos;
			}
			if (is_readable( $this->getViewPath().'/_' . lcfirst($pagina['partial']) . '.php' ))
			$contenido = $this->renderPartial('_' . lcfirst($pagina['partial']), array('contenido' => $pagina), true);
			else $contenido = '';
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
		$micrositio = ($id)?Micrositio::model()->with('seccion')->findByPk($id)->id:0;
		$model = new Pagina;
		$model->micrositio_id = $micrositio;
		switch($tipo_pagina_id)
		{
			case 2:
				$ppc = 'PgGenericaSt';
				break;
			case 3:
				$ppc = 'PgArticuloBlog';
				break;
			case 4:
				$ppc = 'PgDocumental';
				break;
			case 8:
				$ppc = 'PgFiltro';
				break;
			case 10:
				$ppc = 'PgBloques';
				break;
			case 11:
				$ppc = 'PgBlog';
				break;
			case 12:
				$ppc = 'PgEventos';
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
			$m = Micrositio::model()->with('seccion')->findByPk($_POST['Pagina']['micrositio_id']);
			$model->tipo_pagina_id = $tipo_pagina_id;
			
			if($model->save()){
				
				if( isset(Yii::app()->session['dirpa']) ){
					$dirpa = Yii::app()->session['dirpa'];
				}
				if(isset($_POST['PgGenericaSt']))
				{
					$contenido->imagen 	= ($_POST['PgGenericaSt']['imagen'] != '')?$dirpa . $_POST['PgGenericaSt']['imagen']:NULL;
					$contenido->imagen_mobile 	= ($_POST['PgGenericaSt']['imagen_mobile'] != '')?$dirpa . $_POST['PgGenericaSt']['imagen_mobile']:NULL;
					$contenido->miniatura 		= ($_POST['PgGenericaSt']['miniatura'])?$dirpa . $_POST['PgGenericaSt']['miniatura']:NULL;
					$contenido->texto = $_POST['PgGenericaSt']['texto'];
				}
				if(isset($_POST['PgArticuloBlog']))
				{
					$contenido->imagen 	= ($_POST['PgArticuloBlog']['imagen'] != '')?$dirpa . $_POST['PgArticuloBlog']['imagen']:NULL;
					$contenido->imagen_mobile 	= ($_POST['PgArticuloBlog']['imagen_mobile'] != '')?$dirpa . $_POST['PgArticuloBlog']['imagen_mobile']:NULL;
					$contenido->miniatura 		= ($_POST['PgArticuloBlog']['miniatura'])?$dirpa . $_POST['PgArticuloBlog']['miniatura']:NULL;
					$contenido->posicion 	= $_POST['PgArticuloBlog']['posicion'];
					$contenido->entradilla 	= $_POST['PgArticuloBlog']['entradilla'];
					$contenido->texto 		= $_POST['PgArticuloBlog']['texto'];
					$contenido->enlace 		= $_POST['PgArticuloBlog']['enlace'];
					$contenido->comentarios = $_POST['PgArticuloBlog']['comentarios'];
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
					$contenido->miniatura 	  = ($_POST['PgFiltro']['miniatura'])?$dirpa . $_POST['PgFiltro']['miniatura']:NULL;
					$contenido->descripcion   = $_POST['PgFiltro']['descripcion'];
				}
				if(isset($_POST['PgBloques']))
				{
					$contenido->imagen 	= ($_POST['PgBloques']['imagen'] != '')?$dirpa . $_POST['PgBloques']['imagen']:NULL;
					$contenido->imagen_mobile = ($_POST['PgBloques']['imagen_mobile'] != '')?$dirpa . $_POST['PgBloques']['imagen_mobile']:NULL;
					$contenido->miniatura 	  = ($_POST['PgBloques']['miniatura'])?$dirpa . $_POST['PgBloques']['miniatura']:NULL;
				}
				if(isset($_POST['PgEventos']))
				{
					$contenido->imagen 	= ($_POST['PgEventos']['imagen'] != '')?$dirpa . $_POST['PgEventos']['imagen']:NULL;
					$contenido->imagen_mobile = ($_POST['PgEventos']['imagen_mobile'] != '')?$dirpa . $_POST['PgEventos']['imagen_mobile']:NULL;
					$contenido->miniatura 	  = ($_POST['PgEventos']['miniatura'])?$dirpa . $_POST['PgEventos']['miniatura']:NULL;
					$contenido->descripcion   = $_POST['PgEventos']['descripcion'];
				}
				if(isset($_POST['PgBlog']))
				{
					$contenido->ver_fechas 	= $_POST['PgBlog']['ver_fechas'];
					
				}
				$contenido->estado = $_POST['Pagina']['estado'];
				$contenido->pagina_id = $model->getPrimaryKey();
				if($contenido->save())
					$this->redirect(array('view','id'=>$model->id));
				else
					$model->delete();
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
		$contenido = $datos['contenido'];

		if(isset($_POST['Pagina']))
		{
			$m = Micrositio::model()->with('seccion')->findByPk($datos['pagina']->micrositio_id);

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
				if(isset($_POST['PgArticuloBlog']))
				{
					$contenido = PgArticuloBlog::model()->findByPk($_POST['PgArticuloBlog']['id']);
					
					if($_POST['PgArticuloBlog']['imagen'] != $contenido->imagen)
					{
						@unlink( Yii::getPathOfAlias('webroot').'/images/' . $contenido->imagen);
						$contenido->imagen 	= ($_POST['PgArticuloBlog']['imagen'] != '')?$dirpa . $_POST['PgArticuloBlog']['imagen']:NULL;
					}
					if($_POST['PgArticuloBlog']['imagen_mobile'] != $contenido->imagen_mobile)
					{
						@unlink( Yii::getPathOfAlias('webroot').'/images/' . $contenido->imagen_mobile);
						$contenido->imagen_mobile 	= ($_POST['PgArticuloBlog']['imagen_mobile'] != '')?$dirpa . $_POST['PgArticuloBlog']['imagen_mobile']:NULL;
					}
					if($_POST['PgArticuloBlog']['miniatura'] != $contenido->miniatura)
					{
						@unlink( Yii::getPathOfAlias('webroot').'/images/' . $contenido->miniatura);
						$contenido->miniatura 	= ($_POST['PgArticuloBlog']['miniatura'] != '')?$dirpa . $_POST['PgArticuloBlog']['miniatura']:NULL;
					}
					$contenido->posicion 	= $_POST['PgArticuloBlog']['posicion'];
					$contenido->entradilla 	= $_POST['PgArticuloBlog']['entradilla'];
					$contenido->texto 		= $_POST['PgArticuloBlog']['texto'];
					$contenido->enlace 		= $_POST['PgArticuloBlog']['enlace'];
					$contenido->comentarios = $_POST['PgArticuloBlog']['comentarios'];
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
				if(isset($_POST['PgBloques']))
				{
					$contenido = PgBloques::model()->findByPk($_POST['PgBloques']['id']);
					if($_POST['PgBloques']['imagen'] != $contenido->imagen)
					{
						@unlink( Yii::getPathOfAlias('webroot').'/images/' . $contenido->imagen);
						$contenido->imagen 	= ($_POST['PgBloques']['imagen'] != '')?$dirpa . $_POST['PgBloques']['imagen']:NULL;
					}
					if($_POST['PgBloques']['imagen_mobile'] != $contenido->imagen_mobile)
					{
						@unlink( Yii::getPathOfAlias('webroot').'/images/' . $contenido->imagen_mobile);
						$contenido->imagen_mobile 	= ($_POST['PgBloques']['imagen_mobile'] != '')?$dirpa . $_POST['PgBloques']['imagen_mobile']:NULL;
					}
					if($_POST['PgBloques']['miniatura'] != $contenido->miniatura)
					{
						@unlink( Yii::getPathOfAlias('webroot').'/images/' . $contenido->miniatura);
						$contenido->miniatura 	= ($_POST['PgBloques']['miniatura'] != '')?$dirpa . $_POST['PgBloques']['miniatura']:NULL;
					}
				}
				if(isset($_POST['PgEventos']))
				{
					$contenido = PgEventos::model()->findByPk($_POST['PgEventos']['id']);
					if($_POST['PgEventos']['imagen'] != $contenido->imagen)
					{
						@unlink( Yii::getPathOfAlias('webroot').'/images/' . $contenido->imagen);
						$contenido->imagen 	= ($_POST['PgEventos']['imagen'] != '')?$dirpa . $_POST['PgEventos']['imagen']:NULL;
					}
					if($_POST['PgEventos']['imagen_mobile'] != $contenido->imagen_mobile)
					{
						@unlink( Yii::getPathOfAlias('webroot').'/images/' . $contenido->imagen_mobile);
						$contenido->imagen_mobile 	= ($_POST['PgEventos']['imagen_mobile'] != '')?$dirpa . $_POST['PgEventos']['imagen_mobile']:NULL;
					}
					if($_POST['PgEventos']['miniatura'] != $contenido->miniatura)
					{
						@unlink( Yii::getPathOfAlias('webroot').'/images/' . $contenido->miniatura);
						$contenido->miniatura 	= ($_POST['PgEventos']['miniatura'] != '')?$dirpa . $_POST['PgEventos']['miniatura']:NULL;
					}
					$contenido->descripcion = $_POST['PgEventos']['descripcion'];
				}
				if(isset($_POST['PgBlog']))
				{
					$contenido = PgBlog::model()->findByPk($_POST['PgBlog']['id']);
					$contenido->ver_fechas 	= $_POST['PgBlog']['ver_fechas'];
				}

				$contenido->estado = $_POST['Pagina']['estado'];

				if(isset($contenido) && $contenido->save())
					$this->redirect(array('view', 'id'=>$datos['pagina']->getPrimaryKey()));
			}
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
		$pagina = Pagina::model()->with('micrositios', 'url', 'tipoPagina')->findByPk($id);
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

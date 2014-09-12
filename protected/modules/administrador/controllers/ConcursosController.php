<?php
class ConcursosController extends Controller
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
                'directorio' => 'images/concursos/' . date('Y') . '/' . date('m') . '/',
                'param_name' => 'archivoImagen'
            ),
            'imagen_mobile'=>array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/concursos/' . date('Y') . '/' . date('m') . '/',
                'param_name' => 'archivoImagenMobile'
            ),
            'miniatura'=> array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/concursos/' . date('Y') . '/' . date('m') . '/thumbnail/',
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
		Yii::app()->session->remove('dir');
		Yii::app()->session->remove('dirc');
		$dataProvider = new CActiveDataProvider('Micrositio', array(
													    'criteria'=>array(
													        'condition'=>'seccion_id = 8',
													        'order'=>'creado DESC',
													        /*'with'=>array('author'),*/
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
		if( 
			isset($_POST['asignar_menu']) || 
			Yii::app()->user->checkAccess('asignar_menus') ||
			Yii::app()->user->checkAccess('asignar_menu_concursos')
		)
		{
			$this->asignar_menu($id, $_POST['Micrositio']['menu_id']);
		}

		$model = Micrositio::model()->with('url', 'pagina', 'menu')->findByPk($id);
		$contenido = PgGenericaSt::model()->findByAttributes(array('pagina_id' => $model->pagina->id));
		$fotos = new CActiveDataProvider( 'AlbumFoto', array(
													    'criteria'=>array(
													        'condition'=>'micrositio_id = '.$id,
													        'with'=>array('fotos', 'url'),
													    )) );
		$videos = new CActiveDataProvider( 'AlbumVideo', array(
													    'criteria'=>array(
													        'condition'=>'micrositio_id = '.$id,
													        'with'=>array('videos', 'url'),
													    )) );
		$paginas = new CActiveDataProvider( 'Pagina', array(
													    'criteria'=>array(
													        'condition'=>'micrositio_id=' . $id . ' AND tipo_pagina_id=2',
													        'with'=>array('pgGenericaSts', 'url'),
													    )) );

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
			'fotos' => $fotos, 
			'videos' => $videos, 
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCrear()
	{
		if( !isset(Yii::app()->session['dirc']) ) Yii::app()->session['dirc'] = 'concursos/' . date('Y') . '/' . date('m') . '/';

		$concursosForm = new ConcursosForm;

		if(isset($_POST['ConcursosForm'])){
			$concursosForm->attributes = $_POST['ConcursosForm'];
			if( isset(Yii::app()->session['dirc']) ){
				$dirc = Yii::app()->session['dirc'];
			}
			if($concursosForm->validate()){
				$micrositio 				= new Micrositio;
				$transaccion 				= $micrositio->dbConnection->beginTransaction();
				$micrositio->seccion_id 	= 8; //Concursos
				$micrositio->usuario_id 	= 1;
				$micrositio->nombre			= $concursosForm->nombre;
				$micrositio->background 	= ($concursosForm->imagen != '')?$dirc . $concursosForm->imagen:NULL;
				$micrositio->background_mobile 	= ($concursosForm->imagen_mobile != '')?$dirc . $concursosForm->imagen_mobile:NULL;
				$micrositio->miniatura 		= ($concursosForm->miniatura)?$dirc . $concursosForm->miniatura:NULL;
				$micrositio->destacado		= $concursosForm->destacado;
				$micrositio->estado			= $concursosForm->estado;
				if( !$micrositio->save(false) ) $transaccion->rollback();
				$micrositio_id = $micrositio->getPrimaryKey();

				$pagina = new Pagina;
				$pagina->micrositio_id 	  = $micrositio_id;
				$pagina->tipo_pagina_id   = 2; //Generica
				$pagina->nombre			  = $concursosForm->nombre;
				$pagina->meta_descripcion = $concursosForm->meta_descripcion;
				$pagina->clase 			  = NULL;
				$pagina->destacado		  = $concursosForm->destacado;
				$pagina->estado			  = ($concursosForm->estado == 2)?1:$concursosForm->estado;
				if( !$pagina->save(false) ) $transaccion->rollback();
				$pagina_id = $pagina->getPrimaryKey();

				$micrositio->pagina_id = $pagina_id;
				$micrositio->save(false);

				if($concursosForm->formulario != '')
				{
					
					$formulario = new Pagina;
					$formulario->micrositio_id = $micrositio_id;
					$formulario->tipo_pagina_id = 7;								
					$formulario->nombre = 'Escribenos';	
					$formulario->estado = 1;
					$formulario->destacado = 0;
					$formulario->save();
					$pgF = new PgFormularioJf;
					$pgF->pagina_id 	= $formulario->getPrimaryKey();
					$pgF->formulario_id	= $concursosForm->formulario;
					$pgF->estado 		= 1;
					$pgF->save();
				}

				$pgGst = new PgGenericaSt;
				$pgGst->pagina_id 	= $pagina_id;
				$pgGst->texto 		= $concursosForm->texto;
				$pgGst->estado 		= 1;
				
				if( !$pgGst->save(false) )
					$transaccion->rollback();
				else
				{
					$transaccion->commit();
					Yii::app()->user->setFlash('mensaje', 'Concurso ' . $concursosForm->nombre . ' guardado con éxito');
					$this->redirect('index');
				}
				

			}//if($novedadesForm->validate())

		} //if(isset($_POST['NovedadesForm']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$this->render('crear',array(
			'model'=>$concursosForm,
		));
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{

		if( !isset(Yii::app()->session['dirc']) ) Yii::app()->session['dirc'] = 'concursos/' . date('Y') . '/' . date('m') . '/';

		$micrositio = Micrositio::model()->with('url', 'pagina')->findByPk($id);
		$pagina = Pagina::model()->with('url', 'pgGenericaSts')->findByAttributes(array('micrositio_id' => $micrositio->id));
		$formulario = Pagina::model()->with('url', 'pgFormularioJfs')->findByAttributes(array('micrositio_id' => $micrositio->id, 'tipo_pagina_id' => 7));
		
		$concursosForm = new ConcursosForm;
		$concursosForm->id = $id;
		
		if(isset($_POST['ConcursosForm'])){
			$concursosForm->attributes = $_POST['ConcursosForm'];
			if( isset(Yii::app()->session['dirc']) ){
				$dirc = Yii::app()->session['dirc'];
			}
			if($concursosForm->validate()){
				$micrositio 		= Micrositio::model()->findByPk($id);
				$micrositio->nombre	= $concursosForm->nombre;
				if($concursosForm->imagen != $micrositio->background)
				{
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $micrositio->background);
					$micrositio->background 	= $dirc . $concursosForm->imagen;
				}
				if($concursosForm->imagen_mobile != $micrositio->background_mobile)
				{
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $micrositio->background_mobile);
					$micrositio->background_mobile 	= $dirc . $concursosForm->imagen_mobile;
				}
				if($concursosForm->miniatura != $micrositio->miniatura)
				{
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $micrositio->miniatura);
					$micrositio->miniatura 	= $dirc . $concursosForm->miniatura;
				}

				$micrositio->destacado 	= $concursosForm->destacado;
				$micrositio->estado		= $concursosForm->estado;
				$micrositio->save();

				$pagina = Pagina::model()->findByAttributes(array('micrositio_id' => $micrositio->id));
				$pagina->nombre			  = $concursosForm->nombre;
				$pagina->meta_descripcion = $concursosForm->meta_descripcion;
				$pagina->destacado		  = $concursosForm->destacado;
				$pagina->estado			  = ($concursosForm->estado == 2)?1:$concursosForm->estado;
				$pagina->save();

				//Verifico si el formulario trae un valor diferente al que tiene la base de datos.
				if($concursosForm->formulario != $formulario->pgFormularioJfs->formulario_id)
				{
					//Verifico si el formulario trae contenido
					if($concursosForm->formulario != '')
					{
						//Verifico si en la base de datos ya está creada la página de formulario
						if( is_null($formulario) )
						{
							//Creo la página
							$formulario = new Pagina;
							$formulario->micrositio_id = $micrositio->id;
							$formulario->tipo_pagina_id = 7;								
							$formulario->nombre = 'Escribenos';	
							$formulario->estado = 1;
							$formulario->destacado = 0;
							$formulario->save();
							$pgF = new PgFormularioJf;
						}else
							$pgF = PgFormularioJf::model()->findByAttributes(array('pagina_id' => $formulario->id));
						//Asigno el id del formulario
						$pgF->pagina_id 	= $formulario->getPrimaryKey();
						$pgF->formulario_id	= $concursosForm->formulario;
						$pgF->estado 		= 1;
						$pgF->save();
					}else
						if( !is_null($formulario) ) $formulario->delete();
				}

				$pgGst = PgGenericaSt::model()->findByAttributes( array('pagina_id' => $pagina->id) );
				$pgGst->texto 		= $concursosForm->texto;
				
				if( $pgGst->save() )
				{
					Yii::app()->user->setFlash('mensaje', 'Concurso ' . $concursosForm->nombre . ' guardado con éxito');
					$this->redirect(array('view','id' => $concursosForm->id));
				}else
				{
					Yii::app()->user->setFlash('mensaje', 'Concurso ' . $concursosForm->nombre . ' no se pudo guardar');
				}
				

			}//if($novedadesForm->validate())

		} //if(isset($_POST['NovedadesForm']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$concursosForm->nombre = $micrositio->nombre;
		$concursosForm->texto = $pagina->pgGenericaSts->texto;
		$concursosForm->meta_descripcion = $pagina->meta_descripcion;
		$concursosForm->imagen = $micrositio->background;
		$concursosForm->imagen_mobile = $micrositio->background_mobile;
		$concursosForm->miniatura = $micrositio->miniatura;
		$concursosForm->formulario = $formulario->pgFormularioJfs->formulario_id;
		$concursosForm->estado = $micrositio->estado;
		$concursosForm->destacado = $micrositio->destacado;

		$this->render('modificar',array(
			'model'=>$concursosForm,
		));
	}

	public function actionDesasignarmenu($id)
	{
		$m = Micrositio::model()->findByPk($id);
		$m->menu_id = NULL;
		$m->save();
		$this->redirect(bu('/administrador/concursos/view/'. $id . '#menu'));
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
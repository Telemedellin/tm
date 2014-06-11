<?php

class ProgramasController extends Controller
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
                'directorio' => 'images/backgrounds/programas/',
                'param_name' => 'archivoImagen'
            ),
            'imagen_mobile'=>array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/backgrounds/programas/',
                'param_name' => 'archivoImagenMobile'
            ),
            'miniatura'=> array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'images/backgrounds/programas/thumbnail/',
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
		Yii::app()->session->remove('dirp');
		$dataProvider = new CActiveDataProvider('Micrositio', 
													array(
													    'criteria'=>array(
													        'condition'=>'seccion_id = 2',
													        'order'=>'t.nombre ASC',
													        'with'=>array('url'),
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
		if(isset($_POST['asignar_menu']))
		{
			$this->asignar_menu($id, $_POST['Micrositio']['menu_id']);
		}

		$model = Micrositio::model()->with('url', 'pagina', 'menu')->findByPk($id);
		$pagina = Pagina::model()->findByAttributes(array('micrositio_id' => $model->id, 'tipo_pagina_id' => 1));
		$contenido = PgPrograma::model()->with('horario')->findByAttributes(array('pagina_id' => $model->pagina->id));
		
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
		$horario = new CActiveDataProvider( 'Horario', array(
													    'criteria'=>array(
													        'condition'=>'pg_programa_id = '. $pagina->pgProgramas->id,
													        'with'=>array('tipoEmision'),
													    ),
													    'pagination'=>array(
													    	'pageSize'=>25,
													    )) );
		$redes_sociales = new CActiveDataProvider( 'RedSocial', array(
													    'criteria'=>array(
													        'condition'=>'micrositio_id = '.$id,
													        'with'=>array('tipoRedSocial', 'micrositio'),
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
			'contenido' => $pagina->pgProgramas,
			'videos' => $videos, 
			'fotos' => $fotos, 
			'horario' => $horario,
			'redes_sociales' => $redes_sociales,
			'paginas' => $paginas, 
			'menu' => $menu
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
		if( !isset(Yii::app()->session['dirp']) ) Yii::app()->session['dirp'] = 'backgrounds/programas/';

		$programasForm = new ProgramasForm;		

		if(isset($_POST['ProgramasForm'])){
			$programasForm->attributes = $_POST['ProgramasForm'];
			if( isset(Yii::app()->session['dirp']) ){
				$dirp = Yii::app()->session['dirp'];
			}
			if($programasForm->validate()){
				$micrositio 				= new Micrositio;
				$transaccion 				= $micrositio->dbConnection->beginTransaction();
				$micrositio->seccion_id 	= 2; //Programas
				$micrositio->usuario_id 	= 1;
				$micrositio->nombre			= $programasForm->nombre;
				$micrositio->background 	= ($programasForm->imagen != '')?$dirp . $programasForm->imagen:NULL;
				$micrositio->background_mobile 	= ($programasForm->imagen_mobile != '')?$dirp . $programasForm->imagen_mobile:NULL;
				$micrositio->miniatura 		= ($programasForm->miniatura)?$dirp . $programasForm->miniatura:NULL;
				$micrositio->destacado		= $programasForm->destacado;
				$micrositio->estado			= $programasForm->estado;
				if( !$micrositio->save(false) ) $transaccion->rollback();
				$micrositio_id = $micrositio->getPrimaryKey();

				$pagina = new Pagina;
				$pagina->micrositio_id 		= $micrositio_id;
				$pagina->tipo_pagina_id 	= 1; //Página programa
				$pagina->nombre				= $programasForm->nombre;
				$pagina->meta_descripcion	= $programasForm->meta_descripcion;
				$pagina->clase 				= NULL;
				$pagina->destacado			= $programasForm->destacado;
				$pagina->estado				= ($programasForm->estado == 2)?1:$programasForm->estado;
				if( !$pagina->save(false) ) $transaccion->rollback();
				$pagina_id = $pagina->getPrimaryKey();

				$micrositio->pagina_id = $pagina_id;
				$micrositio->save(false);

				if($programasForm->formulario != '')
				{
					$formulario = new Pagina;
					$formulario->micrositio_id = $micrositio_id;
					$formulario->tipo_pagina_id = 7;								
					$formulario->nombre = 'Escríbenos';	
					$formulario->estado = 1;
					$formulario->destacado = 0;
					$formulario->save();

					$pgF = new PgFormularioJf;
					$pgF->pagina_id 	= $formulario->getPrimaryKey();
					$pgF->formulario_id	= $programasForm->formulario;
					$pgF->estado 		= 1;
					$pgF->save();
				}

				$pgP = new PgPrograma;
				$pgP->pagina_id 	= $pagina_id;
				$pgP->resena 		= $programasForm->resena;
				$pgP->estado 		= $programasForm->estado;
				
				if( !$pgP->save(false) )
					$transaccion->rollback();
				else
				{
					$transaccion->commit();
					Yii::app()->user->setFlash('mensaje', 'Programa ' . $programasForm->nombre . ' guardado con éxito');
					$this->redirect('index');
				}

			}//if($novedadesForm->validate())

		} //if(isset($_POST['NovedadesForm']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		
		$this->render('crear',array(
			'model'=>$programasForm,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{

		if( !isset(Yii::app()->session['dirp']) ) Yii::app()->session['dirp'] = 'backgrounds/programas/';

		$micrositio = Micrositio::model()->with('url', 'pagina')->findByPk($id);
		$pagina = Pagina::model()->with('url', 'pgProgramas')->findByAttributes(array('micrositio_id' => $micrositio->id, 'tipo_pagina_id' => 1));
		$pgP = PgPrograma::model()->with('horario')->findByAttributes(array('pagina_id' => $pagina->id));
		$formulario = Pagina::model()->with('url', 'pgFormularioJfs')->findByAttributes(array('micrositio_id' => $micrositio->id, 'tipo_pagina_id' => 7));

		$programasForm = new ProgramasForm;		
		$programasForm->id = $id;

		if(isset($_POST['ProgramasForm'])){
			$programasForm->attributes = $_POST['ProgramasForm'];
			if( isset(Yii::app()->session['dirp']) ){
				$dirp = Yii::app()->session['dirp'];
			}
			if($programasForm->validate()){
				$micrositio = Micrositio::model()->findByPk($id);
				$micrositio->nombre			= $programasForm->nombre;
				if($programasForm->imagen != $micrositio->background)
				{
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $micrositio->background);
					$micrositio->background 	= ($programasForm->imagen != '')?$dirp . $programasForm->imagen:NULL;
				}
				if($programasForm->imagen_mobile != $micrositio->background_mobile)
				{
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $micrositio->background_mobile);
					$micrositio->background_mobile 	= ($programasForm->imagen_mobile != '')?$dirp . $programasForm->imagen_mobile:NULL;
				}
				if($programasForm->miniatura != $micrositio->miniatura)
				{
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $micrositio->miniatura);
					$micrositio->miniatura 	= ($programasForm->miniatura != '')?$dirp . $programasForm->miniatura:NULL;
				}

				$micrositio->estado			= $programasForm->estado;
				$micrositio->destacado		= $programasForm->destacado;
				$micrositio->save();

				$pagina = Pagina::model()->findByAttributes(array('micrositio_id' => $micrositio->id, 'tipo_pagina_id' => 1));
				$pagina->nombre				= $programasForm->nombre;
				$pagina->meta_descripcion	= $programasForm->meta_descripcion;
				$pagina->destacado			= $programasForm->destacado;
				$pagina->estado				= ($programasForm->estado == 2)?1:$programasForm->estado;
				$pagina->save();

				$pgF = PgFormularioJf::model()->findByAttributes(array('pagina_id' => $formulario->id));

				if($programasForm->formulario != $formulario->pgFormularioJfs->formulario_id)
				{
					if($programasForm->formulario != '')
					{
						if(is_null($formulario))
						{
							if($furl->save()){
								$formulario = new Pagina;
								$formulario->micrositio_id = $micrositio->id;
								$formulario->tipo_pagina_id = 7;								
								$formulario->nombre = 'Escríbenos';	
								$formulario->estado = 1;
								$formulario->destacado = 0;
								$formulario->save();
							}
						}
						$pgF->pagina_id 	= $formulario->getPrimaryKey();
						$pgF->formulario_id	= $programasForm->formulario;
						$pgF->estado 		= 1;
						$pgF->save();
					}else{
						
						if($pgF){
							$formulario->delete();
						} 
					}
				}
				$pgP = PgPrograma::model()->findByAttributes( array('pagina_id' => $pagina->id) );
				$pgP->resena 		= $programasForm->resena;
				$pgP->estado 		= $programasForm->estado;
				if( $pgP->save() )
				{
					Yii::app()->user->setFlash('mensaje', 'Programa ' . $programasForm->nombre . ' guardado con éxito');
					$this->redirect(array('view','id' => $programasForm->id));
				}else
				{
					Yii::app()->user->setFlash('mensaje', 'Programa ' . $programasForm->nombre . ' no se pudo guardar');
				}

			}//if($novedadesForm->validate())

		} //if(isset($_POST['NovedadesForm']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$programasForm->nombre = $micrositio->nombre;
		$programasForm->resena = $pagina->pgProgramas->resena;
		$programasForm->imagen = $micrositio->background;
		$programasForm->imagen_mobile = $micrositio->background_mobile;
		$programasForm->miniatura = $micrositio->miniatura;
		$programasForm->meta_descripcion = $pagina->meta_descripcion;
		$programasForm->formulario = $formulario->pgFormularioJfs->formulario_id;
		$programasForm->estado = $pagina->pgProgramas->estado;
		$programasForm->destacado = $micrositio->destacado;

		$this->render('modificar',array(
			'model'=>$programasForm,
		));
	}

	public function actionDesasignarmenu($id)
	{
		$m = Micrositio::model()->findByPk($id);
		$m->menu_id = NULL;
		$m->save();
		$this->redirect(bu('/administrador/programas/view/'. $id . '#menu'));
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

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
                'directorio' => 'images/backgrounds/programas/',
                'param_name' => 'archivoImagen'
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
		$model = Micrositio::model()->with('url', 'pagina')->findByPk($id);
		$contenido = PgPrograma::model()->with('horario')->findByAttributes(array('pagina_id' => $model->pagina->id));
		$videos = new CActiveDataProvider( 'AlbumVideo', array(
													    'criteria'=>array(
													        'condition'=>'micrositio_id = '.$id,
													        'with'=>array('videos', 'url'),
													    )) );
		$horario = new CActiveDataProvider( 'Horario', array(
													    'criteria'=>array(
													        'condition'=>'pg_programa_id = '.$contenido->id,
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

		$this->render('ver', array(
			'model' => $model,
			'contenido' => $contenido,
			'videos' => $videos, 
			'horario' => $horario,
			'redes_sociales' => $redes_sociales,
			'paginas' => $paginas
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
		$imagen = $micrositio->background;
		$miniatura = $micrositio->miniatura;
		$url_id = $micrositio->url_id;
		$micrositio->pagina_id = null;
		$micrositio->save();
		$pagina = Pagina::model()->findByAttributes( array('micrositio_id' => $micrositio->id, 'tipo_pagina_id' => 1) );
		$urlp_id = $pagina->url_id;
		//Borrar PgPrograma
		$PgP = PgPrograma::model()->findByAttributes(array('pagina_id' => $pagina->id));
		$formulario = Pagina::model()->with('url', 'pgFormularioJfs')->findByAttributes(array('micrositio_id' => $micrositio->id, 'tipo_pagina_id' => 7));

		$transaccion = $PgP->dbConnection->beginTransaction();
		if( $PgP->delete() )
		{
			$pgF = PgFormularioJf::model()->findByAttributes(array('pagina_id' => $formulario->id));
			if($pgF){
				$pgF->delete();
				$formulario->delete();
				$furl = Url::model()->findByPk($formulario->url_id)->delete();
			} 
			//Borrar Página
			if( $pagina->delete() ){
				//Borrar Url de pagina
				$urlp = Url::model()->findByPk($urlp_id);
				//Borrar micrositio

				if($micrositio->delete()){
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $miniatura);
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $imagen);
					//Borrar url de micrositio
					$url = Url::model()->findByPk($url_id);
					$url->delete();
					$transaccion->commit();
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
		if( !isset(Yii::app()->session['dirp']) ) Yii::app()->session['dirp'] = 'backgrounds/programas/';

		$programasForm = new ProgramasForm;		

		if(isset($_POST['ProgramasForm'])){
			$programasForm->attributes = $_POST['ProgramasForm'];
			if( isset(Yii::app()->session['dirp']) ){
				$dirp = Yii::app()->session['dirp'];
			}
			if($programasForm->validate()){
				$url = new Url;
				$transaccion 	= $url->dbConnection->beginTransaction();
				$slug = 'programas/' . $this->slugger($programasForm->nombre);
				$slug = $this->verificarSlug($slug);
				$url->slug 		= $slug;
				$url->tipo_id 	= 2; //Micrositio
				$url->estado  	= 1;
				if( !$url->save(false) ) $transaccion->rollback();
				$url_id = $url->getPrimaryKey();

				$micrositio = new Micrositio;
				$micrositio->seccion_id 	= 2; //Programas
				$micrositio->usuario_id 	= 1;
				$micrositio->url_id 		= $url_id;
				$micrositio->nombre			= $programasForm->nombre;
				$micrositio->background 	= ($programassForm->imagen != '')?$dirp . $programassForm->imagen:NULL;
				$micrositio->miniatura 		= ($programasForm->miniatura)?$dirp . 'thumbnail/' . $programasForm->miniatura:NULL;
				$micrositio->destacado		= $programasForm->destacado;
				if($programasForm->estado > 0) $estado = 1;
				else $estado = 0;
				$micrositio->estado			= $estado;
				if( !$micrositio->save(false) ) $transaccion->rollback();
				$micrositio_id = $micrositio->getPrimaryKey();

				$purl = new Url;
				$pslug = $url->slug .'/inicio';
				$pslug = $this->verificarSlug($pslug);
				$purl->slug 	= $pslug;
				$purl->tipo_id 	= 3; //Pagina
				$purl->estado  	= 1;
				if( !$purl->save(false) ) $transaccion->rollback();
				$purl_id = $purl->getPrimaryKey();

				$pagina = new Pagina;
				$pagina->micrositio_id 	= $micrositio_id;
				$pagina->tipo_pagina_id = 1; //Página programa
				$pagina->url_id 		= $purl_id;
				$pagina->nombre			= $programasForm->nombre;
				$pagina->clase 			= NULL;
				$pagina->destacado		= $programasForm->destacado;
				$pagina->estado			= $estado;
				if( !$pagina->save(false) ) $transaccion->rollback();
				$pagina_id = $pagina->getPrimaryKey();

				$micrositio->pagina_id = $pagina_id;
				$micrositio->save(false);

				if($programasForm->formulario != '')
				{
					$furl = new Url;
					$fslug = $url->slug . '/escribinos';
					$fslug = $this->verificarSlug($fslug);
					$furl->slug = $fslug;
					$furl->tipo_id = 3; //Página
					$furl->estado = 1;
					if($furl->save()){
						$formulario = new Pagina;
						$formulario->micrositio_id = $micrositio_id;
						$formulario->tipo_pagina_id = 7;								
						$formulario->url_id = $furl->getPrimaryKey();
						$formulario->nombre = 'Escribinos';	
						$formulario->estado = 1;
						$formulario->destacado = 0;
						$formulario->save();
					}
					$pgF = new PgFormularioJf;
					$pgF->pagina_id 	= $pagina_id;
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
				if($programasForm->nombre != $micrositio->nombre){
					$url = Url::model()->findByPk($micrositio->url_id);
					$slug = 'programas/' . $this->slugger($programasForm->nombre);
					$slug = $this->verificarSlug($slug);
					$url->slug 		= $slug;
					$url->save(false);

					$purl = Url::model()->findByPk($pagina->url_id);
					$pslug = $url->slug .'/inicio';
					$pslug = $this->verificarSlug($pslug);
					$purl->slug 	= $pslug;
					$purl->save(false);
				}

				$micrositio = Micrositio::model()->findByPk($id);
				$transaccion 	= $micrositio->dbConnection->beginTransaction();
				$micrositio->nombre			= $programasForm->nombre;
				if($programasForm->imagen != $micrositio->background)
				{
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $micrositio->background);
					$micrositio->background 	= ($programasForm->imagen != '')?$dirp . $programasForm->imagen:NULL;
				}
				if($programasForm->miniatura != $micrositio->miniatura)
				{
					@unlink( Yii::getPathOfAlias('webroot').'/images/' . $micrositio->miniatura);
					$micrositio->miniatura 	= ($programasForm->miniatura != '')?$dirp . $programasForm->miniatura:NULL;
				}

				$micrositio->destacado		= $programasForm->destacado;
				if($programasForm->estado > 0) $estado = 1;
				else $estado = 0;
				
				$micrositio->estado			= $estado;
				if( !$micrositio->save(false) ) $transaccion->rollback();

				$pagina = Pagina::model()->findByAttributes(array('micrositio_id' => $micrositio->id, 'tipo_pagina_id' => 1));
				$pagina->nombre			= $programasForm->nombre;
				$pagina->destacado		= $programasForm->destacado;
				$pagina->estado			= $estado;
				if( !$pagina->save(false) ) $transaccion->rollback();

				if($programasForm->formulario != $formulario->pgFormularioJfs->formulario_id)
				{
					if($programasForm->formulario != '')
					{
						if(is_null($formulario))
						{
							
							$furl = new Url;
							$fslug = $micrositio->url->slug . '/escribinos';
							$fslug = $this->verificarSlug($fslug);
							$furl->slug = $fslug;
							$furl->tipo_id = 3; //Página
							$furl->estado = 1;
							if($furl->save()){
								$formulario = new Pagina;
								$formulario->micrositio_id = $micrositio->id;
								$formulario->tipo_pagina_id = 7;								
								$formulario->url_id = $furl->getPrimaryKey();
								$formulario->nombre = 'Escribinos';	
								$formulario->estado = 1;
								$formulario->destacado = 0;
								$formulario->save();
							}
							
						}
						$pgF = new PgFormularioJf;
						$pgF->pagina_id 	= $formulario->id;
						$pgF->formulario_id	= $programasForm->formulario;
						$pgF->estado 		= 1;
						$pgF->save();
					}else{
						$pgF = PgFormularioJf::model()->findByAttributes(array('pagina_id' => $formulario->id));
						if($pgF){
							$pgF->delete();
							$formulario->delete();
							$furl = Url::model()->findByPk($formulario->url_id)->delete();
						} 
					}
				}
				$pgP = PgPrograma::model()->findByAttributes( array('pagina_id' => $pagina->id) );
				$pgP->resena 		= $programasForm->resena;
				$pgP->estado 		= $programasForm->estado;
				if( !$pgP->save(false) )
					$transaccion->rollback();
				else
				{
					$transaccion->commit();
					Yii::app()->user->setFlash('mensaje', 'Programa ' . $programasForm->nombre . ' guardado con éxito');
					$this->redirect(array('view','id' => $programasForm->id));
				}

			}//if($novedadesForm->validate())

		} //if(isset($_POST['NovedadesForm']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$programasForm->nombre = $micrositio->nombre;
		$programasForm->resena = $pagina->pgProgramas->resena;
		$programasForm->imagen = $micrositio->background;
		$programasForm->miniatura = $micrositio->miniatura;
		$programasForm->formulario = $formulario->pgFormularioJfs->formulario_id;
		$programasForm->estado = $pagina->pgProgramas->estado;
		$programasForm->destacado = $micrositio->destacado;

		$this->render('modificar',array(
			'model'=>$programasForm,
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
		$model = Micrositio::model()->with('url', 'pagina')->findByPk($id);

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

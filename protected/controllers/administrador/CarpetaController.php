<?php

class CarpetaController extends Controller
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
				'actions'=>array('crear'),
				'users'=>array('@')
			),
			array('deny',  // deny all users
				'users'=>array('*'),
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCrear($id)
	{
		$p = Pagina::model()->findByPk($id);
		$carpeta = new Carpeta;		

		if(isset($_POST['Carpeta'])){
			$carpeta->attributes = $_POST['Carpeta'];
			
			if($carpeta->validate()){
				$url = new Url;
				$transaccion 	= $url->dbConnection->beginTransaction();
				$slug = '#archivos/' . $this->slugger($carpeta->carpeta);
				$slug = $this->verificarSlug($slug);
				$url->slug 		= $slug;
				$url->tipo_id 	= 10; //Carpeta
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
					$fslug = $url->slug . '/escribenos';
					$fslug = $this->verificarSlug($fslug);
					$furl->slug = $fslug;
					$furl->tipo_id = 3; //Página
					$furl->estado = 1;
					if($furl->save()){
						$formulario = new Pagina;
						$formulario->micrositio_id = $micrositio_id;
						$formulario->tipo_pagina_id = 7;								
						$formulario->url_id = $furl->getPrimaryKey();
						$formulario->nombre = 'Escribenos';	
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
			'model'=>$carpeta,
			'pagina' => $p,
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

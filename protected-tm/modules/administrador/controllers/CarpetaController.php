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
			array('CrugeAccessControlFilter')
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
				'actions'=>array('crear', 'rename', 'renamearchivo', 'delete'),
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
	/*
	public function actionCrear()
	{
		if( !Yii::app()->request->isAjaxRequest || !isset($_POST['name']) || !isset($_POST['parent_id']) )
			 throw new CHttpException(404, 'No se encontró la página solicitada');
		
		$parent 	 	= Carpeta::model()->findByPk($_POST['parent_id']);
		
		$url 		 	= new Url;
		$transaccion 	= $url->dbConnection->beginTransaction();
		$nombre_slug	= $this->slugger($_POST['name']);
		$slug 		 	= $parent->url->slug . '/' . $nombre_slug;
		$slug 		 	= $this->verificarSlug($slug);
		$url->slug 	 	= $slug;
		$url->tipo_id 	= 10; //Carpeta
		$url->estado  	= 1;
		$url->save();
		//if( !$url->save(false) ) $transaccion->rollback();
		$url_id = $url->getPrimaryKey();

		$carpeta 			= new Carpeta();
		$carpeta->url_id 	= $url_id;
		$carpeta->pagina_id = $parent->pagina_id;
		$carpeta->item_id	= $_POST['parent_id'];
		$carpeta->carpeta 	= $_POST['name'];
		$carpeta->ruta 		= $parent->ruta . '/' . $nombre_slug;
		$carpeta->estado 	= 1;
		$carpeta->save();
		//if( !$carpeta->save() ) $transaccion->rollback();
		$src = Yii::getPathOfAlias('webroot').'/archivos/' . $parent->ruta . '/' . $nombre_slug;
		//print_r($src);exit;
		header('Content-type: application/json; charset=UTF-8');
		header('HTTP/1.1 200 OK');
		if( !file_exists( $src ) )
		{
			if( mkdir( $src ) )
			{
				$transaccion->commit();
			    // and the content type
			    $json = '';
				$json .= '{';
				$json .= '"id":"'.$carpeta->getPrimaryKey().'"';
				$json .= '}';
				$json .= '';
				echo $json;
				Yii::app()->end();
			}
		}
		$transaccion->rollback();
		$json = array('error' => '1');
		echo json_encode($json);
		Yii::app()->end();

	}
	/**/

	public function actionCrear()
	{
		if( /*Yii::app()->request->isAjaxRequest ||/**/ !isset($_POST['name']) || !isset($_POST['parent_name']) )
			 throw new CHttpException(404, 'No se encontró la página solicitada');
		
		header('Content-type: application/json; charset=UTF-8');
		header('HTTP/1.1 200 OK');

		try
		{
			$pn 		= addcslashes( $_POST['parent_name'], '%_' );
			$parent 	= Carpeta::model()->find( 'ruta LIKE :pn', array(':pn' => "%$pn%") );

			$carpeta 			= new Carpeta;
			$carpeta->item_id	= $parent->id;
			$carpeta->carpeta 	= $_POST['name'];
			$carpeta->ruta 		= $parent->ruta . '/' . $_POST['name'];
			$carpeta->estado 	= 1;
			if( $carpeta->save() )
				$json = array('success' => $carpeta->getPrimaryKey());
			else
				$json = array('error' => '1');
			//$transaccion->commit();
		}catch(Exception $e)
		{
			//$transaccion->rollback();
			Yii::log(
				PHP_EOL . '<--->'.
				PHP_EOL . $e .
				CLogger::LEVEL_INFO
			);
			$json = array('error' => '1');
		}
		echo json_encode($json);
		//if( !$carpeta->save() ) $transaccion->rollback();
		Yii::app()->end();

	}

	/*
	public function actionRename()
	{
		if( !Yii::app()->request->isAjaxRequest || !isset($_POST['id']) || !isset($_POST['new_name']) )
			 throw new CHttpException(404, 'No se encontró la página solicitada');

		$new_name = $_POST['new_name'];
		$carpeta = Carpeta::model()->with('carpetas')->findByPk($_POST['id']);
		$parent  = Carpeta::model()->findByPk($carpeta->item_id);
		$nueva_ruta 		= $parent->ruta . '/' . $this->slugger($new_name);

		$url = Url::model()->findByPk($carpeta->url_id);
		$nombre_slug	= $this->slugger($_POST['new_name']);
		$slug 		 	= $parent->url->slug . '/' . $nombre_slug;
		$slug 		 	= $this->verificarSlug($slug);
		$url->slug 	 	= $slug;
		$url->save();
		
		$base = Yii::getPathOfAlias('webroot').'/archivos/';
		
		header('HTTP/1.1 200 OK');

		if( rename( $base . $carpeta->ruta, $base . $nueva_ruta ) )
		{
			header('HTTP/1.1 200 OK');
			$carpeta->carpeta 	= $new_name;
			$carpeta->ruta 		= $nueva_ruta;
			if( $carpeta->save() )
			{
				Yii::app()->end();
			}
		}
		$json = array('error' => '1');
		echo json_encode($json);
		Yii::app()->end();
		
	}
	/**/

	public function actionRename()
	{
		if( !Yii::app()->request->isAjaxRequest || !isset($_POST['name']) || !isset($_POST['new_name']) )
			 throw new CHttpException(404, 'No se encontró la página solicitada');

		$new_name 	= $_POST['new_name'];
		$carpeta 	= Carpeta::model()->with('carpetas')->find( 't.ruta LIKE "%'.$_POST['name'].'"' );
		$parent  	= Carpeta::model()->findByPk($carpeta->item_id);
		$nombre_slug= $this->slugger($new_name);
		$nueva_ruta = $parent->ruta . '/' . $nombre_slug;

		$base = Yii::getPathOfAlias('webroot').'/archivos/';
		
		header('HTTP/1.1 200 OK');

		
		header('HTTP/1.1 200 OK');
		$carpeta->carpeta 	= $new_name;
		$carpeta->ruta 		= $nueva_ruta;
		if( !$carpeta->save() )
		{
			$json = array('error' => '1');
			echo json_encode($json);
		}
		Yii::app()->end();
		
	}

	public function actionRenamearchivo()
	{
		if( !Yii::app()->request->isAjaxRequest || !isset($_POST['name']) || !isset($_POST['new_name']) )
			 throw new CHttpException(404, 'No se encontró la página solicitada');

		$new_name		= $_POST['new_name'];
		$archivo 		= Archivo::model()->with('carpeta')->findByAttributes( array('archivo' => $_POST['name']) );
		$parent  		= Carpeta::model()->findByPk($archivo->carpeta_id);
		$nombre_slug	= $this->slugger($new_name);
		$nueva_ruta 	= $parent->ruta . '/' . $nombre_slug;

		$url = Url::model()->findByPk($archivo->url_id);
		$slug 		 	= $parent->url->slug . '/' . $nombre_slug;
		$slug 		 	= $this->verificarSlug($slug);
		$url->slug 	 	= $slug;
		$url->save();
		
		$base = Yii::getPathOfAlias('webroot').'/archivos/';
		
		header('HTTP/1.1 200 OK');

		$archivo->archivo 	= $new_name;
		$archivo->nombre 	= $new_name;
		if( !$archivo->save() )
		{
			$json = array('error' => '1');
			echo json_encode($json);
		}
		Yii::app()->end();
		
	}

	public function actionDelete()
	{
		if( !Yii::app()->request->isAjaxRequest || !isset($_POST['id']) )
			 throw new CHttpException(404, 'No se encontró la página solicitada');

		$carpeta = Carpeta::model()->findByPk( $_POST['id'] );
		
		if( !$carpeta->delete() )
		{
			$json = array('error' => '1');
			echo json_encode($json);
			Yii::app()->end();
		}
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

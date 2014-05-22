<?php
class AlbumfotoController extends Controller
{
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
				'actions'=>array('view', 'crear','update', 'delete'),
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
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = AlbumFoto::model()->with('url', 'micrositio')->findByPk($id);
		$fotos = new CActiveDataProvider( 'Foto', array(
													    'criteria'=>array(
													        'condition'=>'album_foto_id = '.$id,
													        'with'=>array('url'),
													    )) );
		$this->render('ver', array(
			'model' => $model,
			'fotos' => $fotos
		));
	}

	
	public function actionDelete($id)
	{
		$album_foto = AlbumFoto::model()->with('micrositio')->findByPk($id);
		$album_foto->delete();
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	
	public function actionCrear($id)
	{

		$micrositio = ($id)?Micrositio::model()->with('seccion')->findByPk($id):0;
		$album_foto = new AlbumFoto;	
		$album_foto->micrositio_id = $micrositio->id;

		if(isset($_POST['AlbumFoto'])){
			$transaction = $album_foto->dbConnection->beginTransaction();
			$album_foto->attributes = $_POST['AlbumFoto'];
			$directorio = $this->slugger($micrositio->nombre) . '/' . $this->slugger($album_foto->nombre);
			$album_foto->directorio = $directorio . '/';
			$album_foto->creado 	= date('Y-m-d H:i:s');
			
			if($album_foto->save()){
				$micrositio = Micrositio::model()->findByPk($album_foto->micrositio_id);
				$dir = Yii::getPathOfAlias('webroot') . '/images/galeria/' . $directorio;
				if( @mkdir($dir, 0755, true) ){
					$transaction->commit();
					Yii::app()->user->setFlash('mensaje', $album_foto->nombre . ' guardado con éxito');
				}else{
					$transaction->rollBack();
					Yii::app()->user->setFlash('error', $album_foto->nombre . ' no se pudo guardar');
				}
				$this->redirect(bu('administrador/'.$micrositio->seccion->nombre.'/view/' . $micrositio->id));
			}//if($album_foto->save())

		} //if(isset($_POST['AlbumFoto']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		
		$this->render('crear',array(
			'model'=>$album_foto,
		));
	}

	
	public function actionUpdate($id)
	{
		$album_foto = AlbumFoto::model()->findByPk($id);
		$micrositio = Micrositio::model()->with('seccion')->findByPk($album_foto->micrositio_id);

		if(isset($_POST['AlbumFoto'])){
			$nombre = $album_foto->nombre;
			$album_foto->attributes = $_POST['AlbumFoto'];
			if($album_foto->save()){
				Yii::app()->user->setFlash('mensaje', $album_foto->nombre . ' guardado con éxito');
				$this->redirect(bu('administrador/'.$micrositio->seccion->nombre.'/view/' . $album_foto->micrositio_id));
			}//if($album_foto->save())

		}//if(isset($_POST['AlbumFoto']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$this->render('modificar',array(
			'model'=>$album_foto,
		));
	}

	
	public function loadModel($id)
	{
		$model = AlbumFoto::model()->with('micrositio')->findByPk($id);

		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='url-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
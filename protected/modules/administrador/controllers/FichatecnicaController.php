<?php

class FichatecnicaController extends Controller
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
				'actions'=>array('crear','update', 'delete'),
				'users'=>array('@')
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$ficha_tecnica = FichaTecnica::model()->findByPk($id);
		$ficha_tecnica->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : '../');
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCrear($id)
	{
		$ficha_tecnica = new FichaTecnica;	

		if(isset($_POST['FichaTecnica'])){
			$ficha_tecnica->attributes = $_POST['FichaTecnica'];
			$pgDocumental = PgDocumental::model()->with('pagina')->findByPk($ficha_tecnica->pg_documental_id);
			if($ficha_tecnica->save()){
				Yii::app()->user->setFlash('success', $ficha_tecnica->campo . ' guardado con éxito');
					$this->redirect( array('documentales/view', 'id' => $pgDocumental->pagina->micrositio_id));
			}//if($ficha_tecnica->save())

		} //if(isset($_POST['FichaTecnica']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$pgDocumental = ($id)?PgDocumental::model()->with('pagina')->findByPk($id):0;
		$ficha_tecnica->pg_documental_id = $pgDocumental;
		
		$this->render('crear',array(
			'model'=>$ficha_tecnica,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$ficha_tecnica = FichaTecnica::model()->findByPk($id);

		if(isset($_POST['FichaTecnica'])){
			$ficha_tecnica->attributes = $_POST['FichaTecnica'];
			if($ficha_tecnica->save()){
				Yii::app()->user->setFlash('success', $ficha_tecnica->campo . ' guardado con éxito');
				$pgDocumental = PgDocumental::model()->with('pagina')->findByPk($ficha_tecnica->pg_documental_id);
				$this->redirect( array('view', 'id' => $pgDocumental->pagina->micrositio_id));
			}//if($ficha_tecnica->save())

		}//if(isset($_POST['FichaTecnica']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$this->render('modificar',array(
			'model'=>$ficha_tecnica,
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

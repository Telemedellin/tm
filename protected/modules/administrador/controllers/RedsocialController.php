<?php

class RedsocialController extends Controller
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
		$red_social = RedSocial::model()->findByPk($id);
		$red_social->delete();
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
		$red_social = new RedSocial;	

		if(isset($_POST['RedSocial'])){
			$red_social->attributes = $_POST['RedSocial'];
			$micrositio = Micrositio::model()->with('pagina')->findByPk($red_social->micrositio_id);
			if($red_social->save()){
				Yii::app()->user->setFlash('success', $red_social->tipoRedSocial->nombre . ' ' . $red_social->usuario . ' guardado con éxito');
					$this->redirect(bu('administrador/programas/view/' . $micrositio->id));
			}//if($red_social->save())

		} //if(isset($_POST['RedSocial']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$micrositio = ($id)?Micrositio::model()->with('pagina')->findByPk($id):0;
		$red_social->micrositio_id = $micrositio;
		
		$this->render('crear',array(
			'model'=>$red_social,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$red_social = RedSocial::model()->findByPk($id);

		if(isset($_POST['RedSocial'])){
			$red_social->attributes = $_POST['RedSocial'];
			if($red_social->save()){
				Yii::app()->user->setFlash('success', $red_social->tipoRedSocial->nombre . ' ' . $red_social->usuario . ' guardado con éxito');
				$pgDocumental = PgDocumental::model()->with('pagina')->findByPk($red_social->micrositio_id);
				$this->redirect(bu('administrador/programas/view/' . $red_social->micrositio_id));
			}//if($red_social->save())

		}//if(isset($_POST['RedSocial']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$this->render('modificar',array(
			'model'=>$red_social,
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
		$model = RedSocial::model()->findByPk($id);

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

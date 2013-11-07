<?php

class HorarioController extends Controller
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
		$horario = Horario::model()->findByPk($id);
		$horario->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCrear($id)
	{
		$pgPrograma = ($id)?PgPrograma::model()->with('pagina')->findByPk($id):0;
		$horario = new Horario;	
		$horario->pg_programa_id = $pgPrograma;

		if(isset($_POST['Horario'])){
			$horario->attributes = $_POST['Horario'];
			if($horario->save()){
				Yii::app()->user->setFlash('mensaje', Horarios::getDiaSemana($horario->dia_semana) . ' ' . Horarios::hora($horario->hora_inicio) . ' guardado con éxito');
					$this->redirect(bu('administrador/programas/view/' . $pgPrograma->pagina->micrositio_id));
			}//if($horario->save())

		} //if(isset($_POST['Horario']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		
		$this->render('crear',array(
			'model'=>$horario,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$horario = Horario::model()->findByPk($id);

		if(isset($_POST['Horario'])){
			$horario->attributes = $_POST['Horario'];
			
			$horario->hora_inicio = date('Gi', strtotime($horario->hora_inicio));
			$horario->hora_fin = date('Gi', strtotime($horario->hora_fin));
			if($horario->save()){
				Yii::app()->user->setFlash('mensaje', Horarios::getDiaSemana($horario->dia_semana) . ' ' . Horarios::hora($horario->hora_inicio) . ' guardado con éxito');
				$pgPrograma = PgPrograma::model()->with('pagina')->findByPk($horario->pg_programa_id);
				$this->redirect(bu('administrador/programas/view/' . $pgPrograma->pagina->micrositio_id));
			}//if($horario->save())

		}//if(isset($_POST['Horario']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$this->render('modificar',array(
			'model'=>$horario,
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

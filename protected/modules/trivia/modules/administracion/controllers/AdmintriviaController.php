<?php

class AdmintriviaController extends Controller
{
	/**
	 * @var string the default layout for the views.
	 */
	public $layout='//layouts/administrador';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//array('CrugeAccessControlFilter'), 
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
			array('allow', 
				'actions'=>array('index', 'view', 'crear', 'update'),
				'users'=>array('@')
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$model = new Ronda('search');
		
		if(isset($_GET['Ronda']))
			$model->attributes = $_GET['Ronda'];

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionView($id)
	{
		$model = Ronda::model()->findByPk($id);
				
		$preguntas = new CActiveDataProvider( 'Pregunta', array(
													    'criteria'=>array(
													        'condition'=>'rxp.ronda_id = '.$id,
													        'join' => 'JOIN ronda_x_pregunta AS rxp ON t.id = rxp.pregunta_id',
													        'with'=>array('respuestas'),
													    )) );
		
		$this->render('ver', array(
			'model' => $model,
			'preguntas' => $preguntas,
		));
	}

	public function actionCrear()
	{

		$ronda = new Ronda;
		if(isset($_POST['Ronda'])){
			$ronda->attributes = $_POST['Ronda'];
			if($ronda->validate()){
				if( !$ronda->save() )
				{
					Yii::app()->user->setFlash('mensaje', 'La ronda del ' . $ronda->fecha_inicio . ' al ' . $ronda->fecha_fin . ' no se pudo guardar');
				}else
				{
					Yii::app()->user->setFlash('mensaje', 'La ronda del ' . $ronda->fecha_inicio . ' al ' . $ronda->fecha_fin . ' se guardó exitosamente');
					$this->redirect( bu('/trivia/administracion/view/' . $ronda->getPrimaryKey() ));
				}
			}//if($preguntaForm->validate())

		} //if(isset($_POST['Pregunta']))/**/

		$this->render('crear',array(
			'model'=>$ronda,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{

		$ronda = Ronda::model()->findByPk($id);
		
		if(isset($_POST['Ronda'])){
			$ronda->attributes = $_POST['Ronda'];
			if($ronda->validate()){
				if( !$ronda->save() )
				{
					Yii::app()->user->setFlash('mensaje', 'La ronda del ' . $ronda->fecha_inicio . ' al ' . $ronda->fecha_fin . ' no se pudo guardar');
				}else
				{
					Yii::app()->user->setFlash('mensaje', 'La ronda del ' . $ronda->fecha_inicio . ' al ' . $ronda->fecha_fin . ' se guardó exitosamente');
					$this->redirect( bu('/trivia/administracion/view/' . $id));
				}
			}//if($preguntaForm->validate())

		} //if(isset($_POST['Pregunta']))/**/

		$this->render('modificar',array(
			'model'=>$ronda,
		));
	}
}
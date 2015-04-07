<?php

class PreguntaController extends Controller
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
				'actions'=>array('update', 'crear'),
				'users'=>array('@')
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionCrear()
	{

		$pregunta = new Pregunta;
		
		if(isset($_POST['Pregunta'])){
			$pregunta->attributes = $_POST['Pregunta'];
			if($pregunta->validate()){
				if( !$pregunta->save() )
				{
					Yii::app()->user->setFlash('mensaje', 'La pregunta ' . $pregunta->pregunta . ' no se pudo guardar');
				}

				if( isset($_POST['Respuesta']) )
				{
					foreach($_POST['Respuesta'] as $k => $r)
					{
						if($k > 0)
						{
							$respuesta = Respuesta::model()->findByPk( $k );	
						}else
						{
							$respuesta = new Respuesta;
						}
						$respuesta->respuesta = $r['respuesta'];
						$respuesta->es_correcta = $r['es_correcta'];
						$respuesta->save();						
					}
				}

			}//if($preguntaForm->validate())

		} //if(isset($_POST['Pregunta']))/**/

		$this->render('crear',array(
			'model'=>$pregunta,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{

		$pregunta = Pregunta::model()->findByPk($id);
		
		if(isset($_POST['Pregunta'])){
			$pregunta->attributes = $_POST['Pregunta'];
			if($pregunta->validate()){
				if( !$pregunta->save() )
				{
					Yii::app()->user->setFlash('mensaje', 'La pregunta ' . $pregunta->pregunta . ' no se pudo guardar');
				}

				if( isset($_POST['Respuesta']) )
				{
					foreach($_POST['Respuesta'] as $k => $r)
					{
						if($k > 0)
						{
							$respuesta = Respuesta::model()->findByPk( $k );	
						}else
						{
							$respuesta = new Respuesta;
						}
						$respuesta->respuesta = $r['respuesta'];
						$respuesta->es_correcta = $r['es_correcta'];
						$respuesta->save();						
					}
				}

			}//if($preguntaForm->validate())

		} //if(isset($_POST['Pregunta']))/**/

		$this->render('modificar',array(
			'model'=>$pregunta,
		));
	}
}
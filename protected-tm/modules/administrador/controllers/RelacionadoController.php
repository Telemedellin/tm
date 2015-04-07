<?php

class RelacionadoController extends Controller
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
				'actions'=>array(/*'index', 'view', 'crear', 'update', 'delete',/**/ 'asignar', 'desasignar', 'sort'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Lists all models.
	 */
	/*public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Genero', 
													array(
													    'criteria'=>array(
													    	'order'=>'t.nombre ASC',
													    ),
													    'pagination'=>array(
													    	'pageSize'=>50,
													    ),
													)
												);
		$this->render('index', array(
			'dataProvider'=>$dataProvider,
		));
	}/**/

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	/*public function actionView($id)
	{
		$model = Genero::model()->findByPk($id);
				
		$this->render('ver', 
			array(
				'model' => $model
			)
		);
	}/**/

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	/*public function actionCrear()
	{
		$genero = new Genero;
		if(isset($_POST['Genero'])){
			$genero->attributes = $_POST['Genero'];
			if($genero->save()){
				Yii::app()->user->setFlash('success', 'Género ' . $genero->nombre . ' guardado con éxito');
				$this->redirect( array('view', 'id' => $genero->getPrimaryKey()));
			}//if($genero->save())

		} //if(isset($_POST['MenuItem']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		
		$this->render('crear',array(
			'model'=>$genero,
		));
	}/**/

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	/*public function actionUpdate($id)
	{
		$genero = Genero::model()->findByPk($id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Genero']))
		{
			$genero->attributes = $_POST['Genero'];

			if($genero->save())
			{
				$this->redirect( array('view', 'id' => $genero->id));
			}
		}

		$this->render('update',array(
			'model'=> $genero
		));
	}/**/

	/*public function actionDelete($id)
	{
		$genero = Genero::model()->findByPk($id);
		if($genero->delete())
		{
			$this->redirect(Yii::app()->request->urlReferrer);
		}
	}/**/

	public function actionAsignar()
	{
		$mxr = new MicrositioXRelacionado;
		if(isset($_POST['MicrositioXRelacionado'])){
			$mxr->attributes = $_POST['MicrositioXRelacionado'];
			if($mxr->save()){
				Yii::app()->user->setFlash('success', 'El relacionado ' . $mxr->relacionado->nombre . ' fue asignado con éxito');
				$this->redirect(Yii::app()->request->urlReferrer);
			}//if($genero->save())

		} //if(isset($_POST['MenuItem']))

	}

	public function actionDesasignar($id)
	{
		$mxr = MicrositioXRelacionado::model()->findByPk($id);
		if($mxr->delete())
		{
			$this->redirect(Yii::app()->request->urlReferrer);
		}
	}

	public function actionSort()
	{
		if (isset($_POST['items']) && is_array($_POST['items'])) {
			$i = 0;
			foreach ($_POST['items'] as $item) {
				$mxr = MicrositioXRelacionado::model()->findByPk($item);
				$mxr->orden = $i;
				$mxr->save();
				$i++;
			}
		}
	}

}
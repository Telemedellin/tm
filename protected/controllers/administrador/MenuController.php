<?php

class MenuController extends Controller
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
				'actions'=>array('index', 'crear', 'update', 'view', 'updateitem', 'viewitem', 'crearitem', 'deleteitem'),
				'users'=>array('@'),
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Menu', 
													array(
													    'criteria'=>array(
													    	'condition' => 't.id != 1', 
													        'order'=>'t.nombre ASC',
													        'with'=>array('menuItems', 'micrositios'),
													    ),
													    'pagination'=>array(
													    	'pageSize'=>50,
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
		$model = Menu::model()->with('menuItems', 'micrositios')->findByPk($id);
		$menuItems = new CActiveDataProvider( 'MenuItem', array(
										    'criteria'=>array(
										        'condition'=>'menu_id = '.$model->id,
										        'with'=>array('urlx'),
										    )) );
		
		$this->render('ver', 
			array(
				'model' => $model, 
				'menuItems' => $menuItems
			)
		);
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCrear()
	{
		$menu = new Menu;
		if(isset($_POST['Menu'])){
			$menu->attributes = $_POST['Menu'];
			if($menu->save()){
				Yii::app()->user->setFlash('mensaje', 'Menú ' . $menu->nombre . ' guardado con éxito');
				$this->redirect(bu('administrador/menu/view/'. $menu->getPrimaryKey()));
			}//if($menu->save())

		} //if(isset($_POST['MenuItem']))

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		
		$this->render('crear',array(
			'model'=>$menu,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$menu = Menu::model()->findByPk($id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Menu']))
		{
			$menu->attributes = $_POST['Menu'];

			if($menu->save())
			{
				$this->redirect(bu('administrador/menu/view/'. $menu->id));
			}
		}

		$this->render('update',array(
			'model'=> $menu
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionViewitem($id)
	{
		$model = MenuItem::model()->with('menu', 'urlx', 'tipoLink')->findByPk($id);
		
		$this->render('verItem', array('model' => $model));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCrearitem($id)
	{
		if(!$id) throw new CHttpException(404, 'Invalid request');
		$menuItem 	= new MenuItem;
		$menu 		= Menu::model()->findByPk($id);
		if(isset($_POST['MenuItem'])){
			$menuItem->attributes = $_POST['MenuItem'];
			if($menuItem->url_id == '') $menuItem->url_id = NULL;
			if($menuItem->save()){
				Yii::app()->user->setFlash('mensaje', 'Item ' . $menuItem->label . ' guardado con éxito');
				$this->redirect('view/'.$menuItem->getPrimaryKey());
			}//if($menuItem->save())

		} //if(isset($_POST['MenuItem']))

		$paginas = array();
		$micrositios = Micrositio::model()->with('paginas')->findAllByAttributes( array('menu_id' => $id) );
		foreach ($micrositios as $m) {
			foreach($m->paginas as $p)
				$paginas[$p->id] = $p->nombre;
		}
		$menuItem->menu_id = $menu;
		
		$this->render('crearItem',array(
			'model'=>$menuItem,
			'menu' => $menu,
			'paginas' => $paginas
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdateitem($id)
	{
		$menuItem = MenuItem::model()->findByPk($id);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MenuItem']))
		{
			$m = Menu::model()->findByPk($menuItem->menu_id);

			$menuItem->attributes = $_POST['MenuItem'];

			if($menuItem->save())
			{
				$this->redirect(bu('administrador/menu/view/'. $m->id));
			}
		}

		$this->render('updateItem',array(
			'model'=> $menuItem
		));
	}

	public function actionDeleteitem($id)
	{
		$menuItem = MenuItem::model()->findByPk($id);
		if($menuItem->delete())
		{
			$this->redirect(Yii::app()->request->urlReferrer);
		}
	}
   	
    /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Pagina the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Menu::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Pagina $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='menu-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}

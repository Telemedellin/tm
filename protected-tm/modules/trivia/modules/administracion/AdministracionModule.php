<?php
/**
 * AdministracionModule 
 * 
 * @uses CWebModule
 * @author Victor Arias. <victor.arias@telemedellin.tv> 
 * @license /protected/modules/trivia/modules/administracion/LICENSE
 */
class AdministracionModule extends CWebModule
{
	public $defaultController 	= 'admintrivia';
	public $urlRules			= array(
									'trivia/administracion'=>'trivia/administracion/admintrivia',
									'trivia/administracion/<action:\w+>/<id:\d+>'=>'trivia/administracion/admintrivia/<action>',
									'trivia/administracion/<action:\w+>'=>'trivia/administracion/admintrivia/<action>',
								);

	public function init()
	{
		/*$this->setImport(array(
			'trivia.models.*',
		));/**/
	}
	
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			Yii::app()->getModule('cruge')->defaultSessionFilter = 'application.components.MiSesionCruge';
			Yii::app()->user->loginUrl = array('/administrador/ingresar');
			return true;
		}
		else
			return false;
	}
}
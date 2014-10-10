<?php
/**
 * TriviaModule 
 * 
 * @uses CWebModule
 * @author Victor Arias. <victor.arias@telemedellin.tv> 
 * @license /protected/modules/trivia/LICENSE
 */
class TriviaModule extends CWebModule
{
	public $active 				= false;
	public $defaultController 	= 'trivia';
	public $urlRules			= array(
									'trivia/administracion'				=> 'trivia/administracion/admintrivia',
									'trivia/administracion/<action:\w+>/<id:\d+>'=> 'trivia/administracion/admintrivia/<action>',
									'trivia/administracion/<action:\w+>'=> 'trivia/administracion/admintrivia/<action>',
									'trivia/<action:\w+>'				=> 'trivia/trivia/<action>',
									//'trivia/<action>' => 'trivia/trivia/<action>'
									);

	public function init()
	{
		$this->setImport(array(
			'trivia.models.*',
		));
	}
	
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			Yii::app()->getModule('cruge')->defaultSessionFilter = 'application.modules.usuario.components.USesionCruge';
			Yii::app()->user->loginUrl = array('/usuario');
			Yii::app()->theme = 'adminlte';
			return true;
		}
		else
			return false;
	}
}
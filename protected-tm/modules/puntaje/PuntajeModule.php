<?php
/**
 * PuntajeModule 
 * 
 * @uses CWebModule
 * @author Victor Arias. <victor.arias@telemedellin.tv> 
 * @license /protected/modules/puntaje/LICENSE
 */
class PuntajeModule extends CWebModule
{
	public $active 				= false;
	public $defaultController 	= 'puntaje';
	public $urlRules			= array(
									/*'puntaje/administracion'				=> 'puntaje/administracion/adminpuntaje',
									'puntaje/administracion/<action:\w+>/<id:\d+>'=> 'puntaje/administracion/adminpuntaje/<action>',
									'puntaje/administracion/<action:\w+>'=> 'puntaje/administracion/adminpuntaje/<action>',/**/
									'puntaje/<action:\w+>'				=> 'puntaje/puntaje/<action>',
									//'puntaje/<action>' => 'puntaje/puntaje/<action>'
									);

	public function init()
	{
		$this->setImport(array(
			'puntaje.models.*',
		));
	}
	
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			Yii::app()->getModule('cruge')->defaultSessionFilter = 'application.modules.usuario.components.USesionCruge';
			Yii::app()->user->loginUrl = array('/usuario');
			return true;
		}
		else
			return false;
	}
}
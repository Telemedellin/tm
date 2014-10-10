<?php
/**
 * UsuarioModule 
 * 
 * @uses CWebModule
 * @author Victor Arias. <victor.arias@telemedellin.tv> 
 * @license /protected/modules/usuario/LICENSE
 */
class UsuarioModule extends CWebModule
{

	public $urlRules	= array(
							'usuario/salir' => 'usuario/usuario/salir', 
						  	'usuario/recuperarclave' => 'usuario/usuario/recuperarclave', 
						  	'usuario/hastalaproxima' => 'usuario/usuario/hastalaproxima', 
						  	'usuario/gracias' => 'usuario/usuario/gracias', 
						  	'usuario/<controller:\w+>/<action:\w+>/<id:[\w\d]+>' => 'usuario/<controller>/<action>', 
							);
	
	public function init()
	{

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
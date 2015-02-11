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
						  	'usuario/<action:\w+>'=>'usuario/usuario/<action>',
						  	'usuario/<controller:\w+>/<action:\w+>/<id:[\w\d]+>' => 'usuario/<controller>/<action>', 
							);

	private $_assetsUrl;

	public function getAssetsUrl()
	{
		if ($this->_assetsUrl === null)
			$this->_assetsUrl = Yii::app()->getAssetManager()->publish( Yii::getPathOfAlias('usuario.assets'), false, -1, /*YII_DEBUG/**/true ); /**QUITAR EL RESTO DE PARÁMETROS QUE SON PARA DESARROLLO NADA MÁS /**/
		return $this->_assetsUrl;
	}
	
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
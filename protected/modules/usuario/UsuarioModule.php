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
	public function init()
	{
		
	}
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			return true;
		}
		else
			return false;
	}
}
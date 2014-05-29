<?php
/**
 * AdministradorModule 
 * 
 * @uses CWebModule
 * @author Victor Arias. <victor.arias@telemedellin.tv> 
 * @license /protected/modules/administrador/LICENSE
 */
class AdministradorModule extends CWebModule
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
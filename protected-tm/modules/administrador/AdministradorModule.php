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
	public $urlRules	= array(
							'administrador'=>'administrador/admin',
				            'administrador/borrarcache'=>'administrador/admin/borrarcache',
				            'administrador/ingresar'=>'administrador/admin/ingresar',
				            'administrador/registro'=>'administrador/admin/registro',
				            'administrador/salir'=>'administrador/admin/salir',
				            'administrador/recuperar-contrasena'=>'administrador/admin/recuperarcontrasena',
				            'administrador/<controller:\w+>'=>'administrador/<controller>',
				            'administrador/<controller:\w+>/<action:\w+>/<id:\d+>'=>'administrador/<controller>/<action>',
				            'administrador/<controller:\w+>/<action:\w+>/<id:\d+>/<tipo_pagina_id:\d+>'=>'administrador/<controller>/<action>',
				            'administrador/<controller:\w+>/<action:\w+>'=>'administrador/<controller>/<action>',
							);
	
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			Yii::app()->getModule('cruge')->defaultSessionFilter = 'application.components.MiSesionCruge';
			Yii::app()->getModule('cruge')->afterLogoutUrl = Yii::app()->createUrl('administrador/admin');
			Yii::app()->user->loginUrl = Yii::app()->createUrl('administrador/admin/ingresar');
			Yii::app()->theme = 'adminlte';
			return true;
		}
		else
			return false;
	}
}
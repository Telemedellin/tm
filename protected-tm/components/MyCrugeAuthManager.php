<?php
/**
MyCrugeAuthManager

Permite autodetectar controllers y actions definidos en modulos.

Al ser definida como clase para el componente authManager actuara
inmediatamente cuando cruge la requiera, listando los modulos
controllers y actions dentro de la rama 'Variados' en la vista
de edicion de tareas y roles.

instalación:

	1. copiar esta clase en /protected/components/MyCrugeAuthManager.php

	2. editar protected/config/main.php, colocando la ruta de la clase
	del componente authManager para que apunte a esta nueva clase.

	'components'=>array(
		'authManager' => array(
			'class' => 'application.components.MyCrugeAuthManager',
		),
	),

uso:

	1. Cruge invocará atomaticamente a Yii::app()->authManager->autoDetect();

	2. si se quiere invocar manualmente y ver que actions se detectaron:

		$am = new MyCrugeAuthManager;
		$am->init();
		foreach($am->autoDetect() as $itemName)
			printf("%s\n",$itemName);

@author: Christian Salazar H. <christiansalazarh@gmail.com> @salazarchris74
@license protected/modules/cruge/LICENSE
 */
class MyCrugeAuthManager extends CrugeAuthManager
{
    /**
     * enumModuleControllers
     *    lista los nombres de los controllers declarados junto a su modulo.
	 *
     * @return array array('modulox'=>array('contr1','contrl2'),'mod2'=>array(...))
     */
    protected function enumModuleControllers()
    {
		$result=array();
		$skeep=array(".","..","cruge");
		foreach(scandir(Yii::app()->getModulePath()) as $moduleName){
			if(in_array($moduleName,$skeep)) continue;
			$result[$moduleName]=array();
			foreach(scandir(
				Yii::app()->getModule(
					$moduleName)->getControllerPath()) as $file_name){
				if(in_array($file_name,$skeep)) continue;
				if(!strlen($file_name)) continue;
				if("."==$file_name[0]) continue;
				$controllerName = "";
                if ($pos = strpos(strtolower($file_name), "controller.php"))
					$controllerName = substr($file_name, 0, $pos);
				$result[$moduleName][] = $controllerName;
			}
		}
		return $result;
    }

    /**
     * enumModuleActions 
	 *	entrega la lista de actions dentro de un controller de un modulo
     * 
     * @param string $moduleName el modulo
     * @param string $controllerName  el controller dentro del modulo
     * @return array lista de nombres (string) de actions.
     */
    protected function enumModuleActions($moduleName,$controllerName)
    {
        $_enumactions = array();
        $className = $controllerName . 'Controller';
        Yii::import('application.modules.'
				.$moduleName.'.controllers.' . $className, true);
        $refx = new ReflectionClass($className);
        foreach ($refx->getMethods() as $method) {
            if ($method->name != 'actions') {
                if (substr($method->name, 0, 6) == "action") {
                    $_enumactions[] = substr($method->name, 6);
                }
            }
        }
        return $_enumactions;
    }

    /**
     * autoDetect
     *    lee todos los controllers y actions y los almacena si previamente
     *    no estaban registrados.
	 *
	 *	metodo invocado por cruge automaticamente
	 *
     * @access public
     * @return array una lista con todos los authitems detectados
     */
    public function autoDetect()
    {
		parent::autoDetect();  // para que haga lo que esta predefinido
		$authItems = array();
		// agrega cada controller detectado
		foreach($this->enumModuleControllers() as $moduleName=>$controllers){
			foreach($controllers as $controllerName){
				// agrega cada controller como un authItem
            	$itemName = "controller_".strtolower($moduleName)."_"
					. strtolower($controllerName);
				$authItems[] = $itemName;
			}
		}
		// agrega cada action dentro de cada controller detectado
		// pero en una forma especial: /modname/contrllname/action
		foreach($this->enumModuleControllers() as $moduleName=>$controllers){
			foreach($controllers as $controllerName){
				foreach ($this->enumModuleActions(
					$moduleName,$controllerName) as $actionName) {
					$authItems[] = strtolower(sprintf("action_%s_%s_%s",
						$moduleName,$controllerName,$actionName));
				}
			}
		}
		foreach($authItems as $itemName)
            if (!$this->getAuthItem($itemName))
                $this->createAuthItem($itemName,CAuthItem::TYPE_OPERATION,"");

        $this->ensureMenuItemIntegrity();
		return $authItems;
    }

}// finclase
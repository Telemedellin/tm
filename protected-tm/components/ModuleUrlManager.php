<?php
class ModuleUrlManager
{
	public static function collectRules($m = null)
	{
		if($m == null) $m = Yii::app();
		else $m = $m->sender;
		if(!empty($m->modules))
		{
			$cache = $m->getCache();
			foreach($m->modules as $moduleName => $config)
			{
				$urlRules = false;
				if($cache)
					$urlRules = $cache->get('module.urls.'.$moduleName);
				if($urlRules === false){
					$urlRules = array();
					$module = $m->getModule($moduleName);
					if(isset($module->urlRules))
						$urlRules = $module->urlRules;
					if($cache)
						$cache->set('module.urls.'.$moduleName, $urlRules);
				}
				if(!empty($urlRules))
				{
					Yii::app()->getUrlManager()->addRules($urlRules, false);
				}
				//if(!empty($module->modules)) ModuleUrlManager::collectRules($module);
				//Pendiente cambiar la verificación al inicio del método para permitir recorrer sub-módulos
			}
		}
		return true;
	}
}
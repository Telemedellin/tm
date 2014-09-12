<?php
class ModuleUrlManager
{
	public static function collectRules($m = null)
	{
		if($m == null) $m = Yii::app();
		if(!empty($m->modules))
		{
			foreach($m->modules as $moduleName => $config)
			{
				$module = $m->getModule($moduleName);
				if(!empty($module->urlRules))
				{
					$m->getUrlManager()->addRules($module->urlRules, false);
				}
				if(!empty($module->modules)) $this->collectRules($module);
			}
		}
		return true;
	}
}
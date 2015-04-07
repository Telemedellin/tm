<?php
Yii::import('system.web.widgets.CWidget');

class LoginW extends CWidget
{
	public $layout = 'pc';

	public function getModel()
	{
		$model = Yii::app()->user->um->getNewCrugeLogon('login');
        $model->authMode = CrugeFactory::get()->getConfiguredAuthMethodName();
        
		return $model;
	}

	public function run()
	{
		if($this->layout == 'pc')
            $this->render('loginw');
        /*else
            $this->render('loginw_'.$this->layout);/**/
	}
}
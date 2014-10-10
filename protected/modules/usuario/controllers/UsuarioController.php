<?php
class UsuarioController extends Controller
{
	public $defaultAction = 'ingresar';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl',
			//array('CrugeAccessControlFilter'), 
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('ingresar', 'captcha', 'recuperarclave', 'error', 'hastalaproxima', 'gracias'),
				'users'=>array('*'),
			),
            array('allow',
                'actions'=>array('salir'),
                'users'=>array('@'),
            ),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'foreColor' => 0xFFFFFF,
                'transparent' => true
            ),
        );
    }

    public function actionIngresar()
	{
		
        if( !Yii::app()->user->isGuest ) $this->redirect( array('/usuario/perfil') );
        $model = Yii::app()->user->um->getNewCrugeLogon('login');
        $model->authMode = CrugeFactory::get()->getConfiguredAuthMethodName();

        Yii::app()->user->setFlash('loginflash', null);

        Yii::log(__CLASS__ . "\nactionLogin\n", "info");

        if (isset($_POST[CrugeUtil::config()->postNameMappings['CrugeLogon']])) {
            $model->attributes = $_POST[CrugeUtil::config()->postNameMappings['CrugeLogon']];
            if ($model->validate()) {
                if ($model->login(false) == true) {
                    Yii::log(__CLASS__ . "\nCrugeLogon->login() returns true\n", "info");
                    // a modo de conocimiento, Yii::app()->user->returnUrl es
                    // establecida automaticamente por CAccessControlFilter cuando
                    // preFilter llama a accessDenied quien a su vez llama a
                    // CWebUser::loginRequired que es donde finalmente se llama a setReturnUrl
                    $this->redirect(bu('usuario/perfil'));
                } else {
                    Yii::app()->user->setFlash('loginflash', Yii::app()->user->getLastError());
                }
            } else {
                Yii::log(
                    __CLASS__ . "\nCrugeUser->validate es false\n" . CHtml::errorSummary($model)
                    ,
                    "error"
                );
            }
        }
        $this->render('ingresar', array('model' => $model));
	}//public function actionIndex()

	public function actionRecuperarclave()
	{
		if( !Yii::app()->user->isGuest ) $this->redirect( array('/usuario/perfil') );
        $model = Yii::app()->user->um->getNewCrugeLogon('pwdrec');

        Yii::app()->user->setFlash('pwdrecflash', null);

        if (isset($_POST[CrugeUtil::config()->postNameMappings['CrugeLogon']])) {
            $model->attributes = $_POST[CrugeUtil::config()->postNameMappings['CrugeLogon']];
            if ($model->validate()) {
                $newPwd = substr(md5(rand().rand().time()),0,8);
                Yii::app()->user->um->changePassword($model->getModel(), $newPwd);
                //Yii::app()->crugemailer->sendPasswordTo($model->getModel(), $newPwd);
                $this->getModule()->crugemailer->enviar_clave($model->getModel(), $newPwd);
                Yii::app()->user->um->save($model->getModel());
                
                Yii::app()->user->setFlash(
                    'pwdrecflash'
                    ,
                    CrugeTranslator::t('Una nueva clave ha sido enviada a su correo')
                );
            }
        }
        
		$this->render('recuperar', array('model' => $model));
	}

	public function actionSalir()
	{
		Yii::app()->user->logout();
		Yii::app()->session->clear();
		Yii::app()->session->destroy();
		$this->redirect(bu('/'));
	}

	public function actionError($message=''){
		$this->renderText('<h1>Login Error</h1><p>'.$message.'</p>');
	}

    public function actionHastalaproxima()
    {
        if( Yii::app()->user->hasFlash( 'baja' ) )
        {
            $baja_id = Yii::app()->user->getFlash( 'baja');
        }
        elseif( isset($_POST['baja_id']) )
        {
            $baja_id = $_POST['baja_id'];
            $baja = Baja::model()->findByPk( $baja_id );
            $baja->motivo = ($_POST['motivo'] != 'Otro') ? $_POST['motivo'] : $_POST['otro_motivo'];
            if( $baja->save() )
                $this->redirect( array('/usuario/gracias') );
        }
        $this->render( 'hastalaproxima', array('baja_id' => $baja_id) );
    }//public function actionHastalaproxima()

    public function actionGracias()
    {
        $this->render( 'gracias' );
    }

}
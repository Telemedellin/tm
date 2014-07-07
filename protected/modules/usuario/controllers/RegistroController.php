<?php
class RegistroController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			//'accessControl',
			//array('CrugeAccessControlFilter'), 
		);
	}

	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index', 'captcha', 'verificacion'),
				'users'=>array('*'),
			),
			/*array('allow',
				'actions'=>array(''),
				'users'=>array('@'),
			),/**/
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actions()
    {
        return array(
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'foreColor'=>0xFFFFFF,
                'transparent' => true
            ),
        );
    }

	public function actionIndex()
	{
		$model = Yii::app()->user->um->createBlankUser();
		$model->bypassCaptcha = false;
        $model->terminosYCondiciones = true;
        
        if (Yii::app()->user->um->getDefaultSystem()->getn('registerusingterms') == 0) {
            $model->terminosYCondiciones = true;
        }

        // para que cargue los campos del usuario
        Yii::app()->user->um->loadUserFields($model);

        // 'datakey' es el nombre de una variable de sesion establecida por alguna parte que invoque a actionRegistration
        // y que se le pasa a este action para de ahi se lean datos.
        //
        // el dato esperado alli es un array indexado ('attribuye'=>'value') tales valores deberan usarse para inicializar el formulario del usuario como se indica aqui:
        //
        // ejemplo de array en sesion:
        //	array('username'=>'csalazar','email'=>'micorreo@x.com', 'nombre'=>'christian', 'apellido'=>'salazar')
        //
        // siendo: "nombre" y "apellido" los nombre de campos personalizados que inmediantamente tras registro seran inicializados.
        //
        if ($datakey != null) {
            // leo la data de la varibale de sesion
            $s = new CHttpSession();
            $s->open();
            $values = $s[$datakey];
            $s->close();
            // asumo que es un array, asi que aqui vamos
            //
            $model->username = $values['username'];
            $model->email = $values['email'];
            // ahora, procesa los campos personalizados, rellenando aquellos mapeados contra los campos existentes:
            foreach ($model->getFields() as $f) {
                if (isset($values[$f->fieldname])) {
                    $f->setFieldValue($values[$f->fieldname]);
                }
            }
        }

        if (isset($_POST[CrugeUtil::config()->postNameMappings['CrugeStoredUser']])) {
            $model->attributes = $_POST[CrugeUtil::config()->postNameMappings['CrugeStoredUser']];
            if ($model->validate()) {

                $newPwd = trim($model->newPassword);
                Yii::app()->user->um->changePassword($model, $newPwd);

                Yii::app()->user->um->generateAuthenticationKey($model);

                if (Yii::app()->user->um->save($model, 'insert')) {

                    $this->onNewUser($model, $newPwd);

                    //ENVIAR CORREO DE VERIFICACIÓN

                    $this->redirect(array('verificacion'));
                }
            }
        }

		$fondo_pagina = 'backgrounds/generica-interna-1.jpg';

		$this->render(
			'index', 
			array(	
				'model' => $model, 
				'fondo_pagina' => $fondo_pagina, 
			)
		);
	}
    public function actionVerificacion()
    {
        $this->render('verificacion');
    }



}
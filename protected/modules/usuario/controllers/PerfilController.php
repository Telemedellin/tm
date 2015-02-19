<?php
class PerfilController extends Controller
{
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
				'actions'=>array('verificacion'),
				'users'=>array('*'),
			),
			array('allow', 
				'actions'=>array('index', 'cambiarcorreo', 'cambiarclave', 'borrarcuenta'),
				'users'=>array('@'),
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

   	public function actionIndex()
	{
		$id = Yii::app()->user->id;
		if( !$id ) $this->redirect(bu('/usuario'));

		$usuario_cruge = Yii::app()->user->um->loadUserById($id);
		$usuario = Usuario::model()->findByAttributes( array('cruge_user_id' => $id) );
		if( !$usuario || !$usuario_cruge ) $this->redirect( array('/usuario') );

		$registroForm = new RegistroForm;

		$this->performAjaxValidation($registroForm);
		$registroForm->scenario = 'update';

        if( isset($_POST['RegistroForm']) ){
        	
            $registroForm->attributes = $_POST['RegistroForm'];

            if( $registroForm->validate() ){ 

                if( $usuario->guardar_datos_usuario( $usuario_cruge, $registroForm ) )
                {
                    Yii::app()->user->setFlash('success', "Los cambios se guardaron exitosamente");
                    $this->redirect( array('/usuario/perfil') );
                }else
                {
					Yii::app()->user->setFlash('error', "No se pudieron guardar los cambios");
					Yii::log('No se pudieron guardar los cambios', 'error');
                }
            }//if($registroForm->validate())
            else
            {
            	Yii::log('No se validaron los datos enviados', 'error');
            }
        }else
        {
			$registroForm->correo = $usuario_cruge->email;
			$registroForm->attributes = $usuario->getAttributes();
        }//if(isset($_POST['RegistroForm']))
        if($usuario->nacimiento)
		{
			$registroForm->anio = date('Y', strtotime($usuario->nacimiento));
			$registroForm->mes = date('m', strtotime($usuario->nacimiento));
			$registroForm->dia = date('d', strtotime($usuario->nacimiento));
		}

		$fondo_pagina = 'backgrounds/generica-interna-1.jpg';

        $this->render(
			'index', 
			array(	
				'model'			=> $registroForm, 
				'usuario'       => $usuario, 
				'fondo_pagina'  => $fondo_pagina, 
			)
		);
	}//public function actionIndex()

	public function actionCambiarcorreo()
	{
		$mail_validator = new CEmailValidator;
		if( 
			isset($_POST['RegistroForm']['correo']) && 
			isset($_POST['RegistroForm']['repetir_correo']) && 
			$_POST['RegistroForm']['correo'] == $_POST['RegistroForm']['repetir_correo'] &&
			$mail_validator->validateValue( $_POST['RegistroForm']['correo'] ) && 
			!Yii::app()->user->um->loadUser($_POST['RegistroForm']['correo'])
		)
		{
			$correo = $_POST['RegistroForm']['correo'];
			$usuario_cruge = Yii::app()->user->um->loadUserById(Yii::app()->user->id);
			$usuario_cruge->authkey = md5(uniqid(time().rand(), true));
			$usuario_cruge->util = $correo;

			if( Yii::app()->user->um->save($usuario_cruge) ){
				$this->getModule()->crugemailer->verificar_correo($usuario_cruge);
				$msg = json_encode( array('email' => $usuario_cruge->email) );
			}else
				$msg = json_encode( array('error' => "No se pudo guardar el correo"));
		}
		else
		{
			$msg = json_encode(array('error' => "Ocurrió un error"));
		}
		echo header('Content-type: application/json; charset=UTF-8');
		echo $msg;

	}

	public function actionCambiarclave()
	{
		if( 
			isset($_POST['RegistroForm']['contrasena']) && 
			isset($_POST['RegistroForm']['repetir_contrasena']) && 
			$_POST['RegistroForm']['contrasena'] == $_POST['RegistroForm']['repetir_contrasena']
		)
		{
			$contrasena = $_POST['RegistroForm']['contrasena'];
			$usuario_cruge = Yii::app()->user->um->loadUserById(Yii::app()->user->id);
			Yii::app()->user->um->changePassword($usuario_cruge, $contrasena);
			if( Yii::app()->user->um->save($usuario_cruge) ){
				echo json_encode( array('email' => $usuario_cruge->email) );
			}else
				echo '{error: "No se pudo cambiar la contraseña"}';
		}
		else
		{
			echo '{error: "Ocurrió un error"}';
		}

	}

	public function actionVerificacion($id = '')
    {
        if( $id != '')
        {
           	$model = Yii::app()->user->um->loadUserByKey($id);
        	if ($model != null && !is_null($model->util) ) {
        		
                $model->authkey = NULL;
                $model->email = $model->util;
                $model->util = NULL;
                if (Yii::app()->user->um->save($model)) {
                	$mensaje = 'correo';
                }else
                {
                	$mensaje = 'No';
                }
                Yii::app()->user->setFlash('verificacion', $mensaje);
	        }
	        else
	        {
	        	$this->redirect( array('/usuario/perfil') );
	        }
	        
        }
        else
        	$this->redirect( array('/usuario/perfil') );

        $this->render('verificacion');
        
    }//public function actionVerificacion()

	public function actionBorrarcuenta()
	{
		if( isset($_POST['contrasena']) )
		{
			$usuario_cruge = Yii::app()->user->um->loadUserById( Yii::app()->user->id );
    		if( Bcrypt::check( $_POST['contrasena'], $usuario_cruge->password ) )
    		{
				$usuario = Usuario::model()->findByAttributes(array('cruge_user_id' => $usuario_cruge->iduser));
				if($usuario->delete())
				{
					Yii::app()->mailchimp->listUnsubscribe($usuario_cruge->email);
					$usuario_cruge->delete();
					$baja = new Baja();
					$baja->fecha = date('Y-m-d H:i:s');
					$baja->motivo = 'Desconocido';
					$baja->save();
					Yii::app()->user->setFlash( 'baja', $baja->getPrimaryKey() );
					$this->redirect( array('usuario/hastalaproxima') );
				}	
    		}
    	}
    	$this->render('borrarcuenta');
    }//public function actionBorrarcuenta()

    protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='perfil')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


}
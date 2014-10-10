<?php
class MiCrugeMailer extends CrugeMailer {

	public function verificar_registro($usuario) {

		//$activation_link = Yii::app()->user->um->getActivationUrl($usuario);
		$authkey = $usuario->authkey;
		$activation_link = Yii::app()->request->getBaseUrl(true) . '/usuario/registro/verificacion/'.$authkey;
		$asunto = 'Activa tu cuenta de telemedellin.tv';
		$vista = $this->render(
			'application.modules.usuario.components.views.micrugemailer.verificar_registro', 
			array('usuario' => $usuario, 'activation_link' => $activation_link) 
		);
		
		$this->sendEmail(
			$usuario->email,
			$asunto, 
			$vista
		);

	}

	public function enviar_clave(ICrugeStoredUser $userInst, $notEncryptedPassword)
    {
        $this->sendEmail(
            $userInst->email,
            self::t("su clave clave de acceso")
            ,
            $this->render(
                'application.modules.usuario.components.views.micrugemailer.enviar_clave'
                ,
                array('model' => $userInst, 'password' => $notEncryptedPassword)
            )
        );
    }

    public function verificar_correo($usuario) {

		$authkey = $usuario->authkey;
		$email = $usuario->util;
		$activation_link = Yii::app()->request->getBaseUrl(true) . '/usuario/perfil/verificacion/'.$authkey;
		$asunto = 'Solicitud de cambio de correo telemedellin.tv';
		$vista = $this->render(
			'application.modules.usuario.components.views.micrugemailer.verificar_correo', 
			array('usuario' => $usuario, 'activation_link' => $activation_link) 
		);
		
		$this->sendEmail(
			$email,
			$asunto, 
			$vista
		);

	}

	public function sendEmail($to, $subject, $body){

		parent::sendEmail($to, $subject, $body);
	}
}
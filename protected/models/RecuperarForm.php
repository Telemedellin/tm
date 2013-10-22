<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RecuperarForm extends CFormModel
{
	public $correo;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('correo', 'required'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'correo'	=> 'Correo',
		);
	}

	public function generarToken()
	{
       	$a = array(
       		'correo' => $this->correo,
       		'estado' => 1,
       	);
       	$validar = Usuario::model()->findByAttributes($a);
       	if($validar){
       		$token = md5( 't3l3m3d3lL1n-hd' . $this->correo . (rand() + time()) . '/T0D0534c14r4*' );
       		$validar->updateByPk($validar->id, array('llave' => $token, 'estado' => 3));
       		/*$mail             = new YiiMailer();
	        $mail->setView('recuperar-clave');
	        $mail->setData( array('token' => $token) );
	        $mail->render();
			$mail->Subject    = 'Recupera tu contraseña del concurso Viaja a Suiza con Medellín 2018';
	        $mail->AddAddress($this->correo);
	        $mail->From = 'contacto@concursomedellin2018.com';
	        $mail->FromName = 'Concurso Medellín 2018';  
	        $mail->Send();*/
       	}
       	return true;
	}
}

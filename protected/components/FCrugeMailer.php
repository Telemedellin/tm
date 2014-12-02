<?php
class FCrugeMailer extends CrugeMailer {

	public function notificar_video($datos)
	{
		$asunto = 'Video de ' . $datos->nombre;
		
		$vista = $this->render(
			'application.components.views.fcrugemailer.notificar_video', 
			array('datos' => $datos) 
		);

		$this->sendEmail(
			'juanpalago@hotmail.com',
			$asunto, 
			$vista
		);
	}

	public function sendEmail($to, $subject, $body){

		parent::sendEmail($to, $subject, $body);
	}
}
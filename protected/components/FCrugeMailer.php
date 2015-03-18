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
			'juanpalalo@hotmail.com',
			$asunto, 
			$vista
		);
	}

	public function enviar_datos_form($correo, $usuario, $model)
	{
		$asunto = 'Mensaje de formulario';// . $model->pgFormulario->pagina->nombre;

		$vista = $this->render(
			'application.components.views.fcrugemailer.enviar_datos_form', 
			array('usuario' => $usuario, 'datos' => $model) 
		);

		$this->sendEmail(
			$correo,
			$asunto, 
			$vista
		);
	}

	public function sendEmail($to, $subject, $body){

		parent::sendEmail($to, $subject, $body);
	}
}
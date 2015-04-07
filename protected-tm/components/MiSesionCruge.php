<?php
/***
	Esta clase sirve para personalizar las acciones de inicio y cierre
	de sesión.
*/
class MiSesionCruge extends DefaultSessionFilter {

	private $tipo_rol;

	/**
		Este evento es invocado cuando un usuario ha hecho LOGIN EXITOSO.
		Puedes tomar tus propias acciones aqui, no se esperan valores de retorno.

		Si quieres controlar a un usuario que ha sido autenticado entonces deberás trabajar en el método aqui provisto: startSession, mas abajo.
		Una cosa es la sesion otra la autenticacion, aqui solo se notifica que un usuario existe.
	*/
	public function onLogin(/*ICrugeSession*/ $model){
		parent::onLogin($model);
		Yii::log("PASANDO POR ONLOGIN","info");
		Yii::app()->getController()->redirect(bu("/administrador"));
	}

	/**
		Permite que puedas indicar que hacer antes de cerrar la sesion.
		Útil porque hay acciones que no podras realizar en onLogout() porque la sesion ya estara cerrada para entonces
		por tanto aqui.
	*/
	public function onBeforeLogout(/*ICrugeSession*/ $model) {
		// por ejemplo, podrias determinar el tipo de usuario (segun su rol) y redirigir al usuario
		// a esa pagina en onLogin() tras el cierre de sesion (NO AQUI !!)
		//
		return true; // o false para que la sesion no se cierre y vuelvas al action de donde vino.
	}

	/**
		Este evento es invocado cuando un usuario ha hecho logout, o cuando explicitamente se invoca a Yii::app()->user->logout.
		Puedes tomar tus propias acciones aqui, no se esperan valores de retorno.
	*/
	public function onLogout(/*ICrugeSession*/ $model) {
		parent::onLogout($model);
		Yii::log("PASANDO POR ONLOGOUT","info");
		Yii::app()->getController()->redirect(bu("/administrador"));
	}

	/**
		Este evento es invocado cuando una sesion ha expirado. No se esperan valores de retorno, solo puedes colocar aqui tus propias acciones.

	*/
	public function onSessionExpired(/*ICrugeSession*/ $model) {
		parent::onSessionExpired($model);
		Yii::log("PASANDO POR ONSESSIONEXPIRED","info");
		/*if( Yii::app()->user->checkAccess('Administrador') || Yii::app()->user->checkAccess('Gestor') )
		{
			Yii::app()->getController()->redirect(array("/administrador"));
		}
		else
		{
			Yii::app()->getController()->redirect(array("/"));
		}/**/
	}

	/**
		Este metodo es invocado por el core de Cruge cuando se requiere una nueva sesion para un usuario que ha iniciado sesión. El proposito aqui es que tu puedas tomar tus propias acciones y decisiones al momento de otorgar una sesion a un usuario, pudiendo revocarla si lo deseas usando a:
			CrugeSession::expiresession()

		Por defecto es altamente recomendado que retornes:

			return parent::startSession($user, $sys);

		Lo que aqui se espera es que se retorne una nueva instancia de un objeto que implemente la interfaz ICrugeSession (por defecto la clase	CrugeSession lo hace y normalmente es la instancia que aqui se retorna)	la implementacion base de startSession usara las siguientes funciones
		del API para hallar y crear una sesion según sea el caso:

			$sesion = Yii::app()->user->um->findSession($user);
		y
			$sesion = Yii::app()->user->um->createSession($user,$sys);

		para caducarla de inmediato usas:

			$sesion->expiresession()

		y luego invoca a :

			$this->onSessionExpired();

		Para otorgar una sesion al usuario se hacen por defecto validaciones contra el estado sistema, la caducidad de la sesion y otras cosas de relevancia.
	*/
	public function startSession(/*ICrugeStoredUser*/ $user,/*ICrugeSystem*/ $sys) {
		Yii::log("PASANDO POR startSession","info");
		return parent::startSession($user, $sys);
	}

}
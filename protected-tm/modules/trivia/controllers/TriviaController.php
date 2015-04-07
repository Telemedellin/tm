<?php

class TriviaController extends Controller
{
	private $_usuario_id= 0;
	private $_preguntaid= 0;
	private $_situacion = 0;
	private $_ronda 	= 0;
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index', 'error', 'test'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	protected function beforeAction($action)
	{
		
		if( $action->id != 'error' && $action->id != 'test')
			$this->verificar_sesion();
		return true;
	}

	public function actionTest()
	{
		echo 'hola';
	}

	public function actionIndex()
	{
		//Cargo la pregunta para responder

		$triviaForm = new TriviaForm;

		if( isset($_POST['TriviaForm']) )
		{
			$triviaForm->attributes = $_POST['TriviaForm'];

			//Verifico que la pregunta sea la misma que la cargada en la sesión
			if( $triviaForm->pregunta != $this->_preguntaid ) $this->_error();

			//Agregar la pregunta a ronda_x_respuesta
			$rxr = new RondaXRespuesta;
			$rxr->ronda_id = $this->_ronda;
			$rxr->respuesta_id = $triviaForm->respuesta;
			$rxr->usuario_id = $this->_usuario_id;
			$rxr->save();

			//Verifico si es la respuesta correcta
			$r = Respuesta::model()->findByPk( $triviaForm->respuesta );

			if( $r->es_correcta )
			{
				$situacion = 3; //3. Respuesta correcta
				$puntos = $rxr->ronda->puntos;
				Yii::app()->user->setFlash('error', 'respuesta-bien');
				Yii::app()->user->setFlash('puntos', $puntos);
				//Sumar puntos
			}else
			{
				$situacion = 4; //4. Respuesta mala
				Yii::app()->user->setFlash('error', 'respuesta-mal');
			}

			
			Yii::app()->session['situacion'] = $this->_situacion = $situacion;
			$this->_error();

		}//if( isset($_POST['TriviaForm']) )
		
		if( $this->_situacion == 2 )
	    {
	    	$pregunta = Pregunta::model()->obtener_pregunta($this->_ronda, $this->_preguntaid);
	    }
	    else
	    {
			$pregunta = Pregunta::model()->obtener_pregunta($this->_ronda);
	    }

	    Yii::app()->session['preguntaid'] = $this->_preguntaid = $pregunta->id;
		Yii::app()->session['situacion'] = $this->_situacion = 2; //2. pregunta  

		foreach($pregunta->respuestas as $r)
		{
			$respuestas[$r->id] = $r->respuesta;
		}
		
	    $this->render('index', array(
								'model' 	 => $triviaForm, 
								'pregunta' 	 => $pregunta,
								'respuestas' => $respuestas,
							)
		);
	}

	private function _error()
	{
		$tipo_error = Yii::app()->user->getFlash('error');

		switch( $tipo_error )
		{
			case 'no-trivias':
				$mensaje = CHtml::tag('p', array(), 'Actualmente no hay trivias activas.');
				break;
			case 'ya-participo':
				$mensaje = CHtml::tag('p', array(), 'Ya participaste esta semana');
				$mensaje .= CHtml::tag('p', array(), 'Espera hasta el próximo lunes a las 8:00 A.M. para volver a participar');
				break;
			case 'respuesta-mal':
				$mensaje = CHtml::tag('p', array(), 'Lo sentimos :(');
				$mensaje .= CHtml::tag('p', array(), 'Nos has contestado correctamente.');
				$mensaje .= CHtml::tag('p', array(), 'Espera hasta el próximo lunes a las 8:00 A.M. para volver a participar');
				break;
			case 'respuesta-bien':
				$puntos = Yii::app()->user->getFlash('puntos');
				$mensaje = CHtml::tag('p', array(), '¡Felicitaciones!');
				$mensaje .= CHtml::tag('p', array(), 'Has ganao ' . $puntos . ' puntos');
				break;
			default:
				$mensaje = CHtml::tag('p', array(), 'Algo pasó, vuelve a intentar lo que estabas haciendo');
		}

		$this->render('error', array('mensaje' => $mensaje));
		Yii::app()->end();
	}

	protected function verificar_sesion()
	{
		//1. Verifico la sesión para inicializar el juego
		if( !isset(Yii::app()->session['ronda']) || Yii::app()->session['ronda'] == 0 )
		{
			if($this->_usuario_id == 0)
			{
				//2. Obtengo el id del usuario
				$usuario = Usuario::model()->find('cruge_user_id = ' . Yii::app()->user->id);
				Yii::app()->session['usuario_id'] = $this->_usuario_id = $usuario->id;
			}

			//Verificar cual es la ronda vigente
			$rondaactual = Ronda::model()->getRondaActual();
			if( !$rondaactual )
			{
				Yii::app()->user->setFlash('error', 'no-trivias');
				$this->_error();
			}

			Yii::app()->session['ronda'] 		= $this->_ronda 	= $rondaactual->id;
			Yii::app()->session['preguntaid']	= $this->_preguntaid= 0;
			Yii::app()->session['situacion']	= $this->_situacion = 1; //1. inicio
		}else
		{
			$this->_ronda  	 	= Yii::app()->session['ronda'];
			$this->_usuario_id 	= Yii::app()->session['usuario_id'];
			$this->_preguntaid 	= Yii::app()->session['preguntaid'];
			$this->_situacion	= Yii::app()->session['situacion'];
		}

		$rxr = RondaXRespuesta::model()->count( 'usuario_id = :usuario_id && ronda_id = :ronda_id', array(':usuario_id' => $this->_usuario_id, ':ronda_id' => $this->_ronda)  );
		$rxp = RondaXPregunta::model()->count( 'ronda_id = :ronda_id', array(':ronda_id' => $this->_ronda) );

		if( $rxr >= $rxp )
		{
			Yii::app()->user->setFlash('error', 'ya-participo');
			$this->_error();
		}

	}//verificar_sesion

	protected function limpiar_sesion()
	{
		//1. Verifico la sesión para inicializar el juego
		if( isset(Yii::app()->session['ronda']) && Yii::app()->session['ronda'] != 0 )
		{
			Yii::app()->session['ronda'] 		= $this->_ronda 	= 0;
			Yii::app()->session['preguntaid']	= $this->_preguntaid= 0;
			Yii::app()->session['situacion']	= $this->_situacion = 0;
		}
	}//limpiar_sesion

}
<?php
class Formulario
{
	public $id;
	public $config;
	private $campos;
	private $enviosCount;
	private $tipos_de_campo;
	private $usuario_id;
	private $PgFormulario;

	public function __construct($form)
	{
		$this->id 			= $form->id;
		$this->config 		= $form;
		$this->PgFormulario	= PgFormulario::model()->with('campo', 'enviosCount')->findByPk( $this->id );
		$this->tipos_de_campo= TipoCampo::model()->findAll();
		$this->campos 		= $this->PgFormulario->campo;
		$this->enviosCount	= $this->PgFormulario->enviosCount;
	}

	public function render()
	{
		//Verifica la sesión de usuario
		
		//Activar en producción
		if( Yii::app()->user->isGuest )
			return $this->mensaje_registro();
		else
			$this->usuario_id = Yii::app()->user->getState('usuario_id');
		/**/
		
		//Verifico su vigencia
		$hoy = date('Y-m-d H:i:s');
		if( $this->config->fecha_apertura != '0000-00-00 00:00:00' && !is_null($this->config->fecha_apertura) && $this->config->fecha_apertura > $hoy )
		{
		    return $this->previo();
		}
		else if( $this->config->fecha_cierre != '0000-00-00 00:00:00' && !is_null($this->config->fecha_cierre) && $this->config->fecha_cierre < $hoy )
		{
		    return $this->posterior();
		}
		else if( $this->config->limite_envios > 0 && $this->config->limite_envios > $this->enviosCount ) //Límite de envíos
		{
			return $this->limite();
		}
		else if( $this->config->limite_por_usuario > 0 && $this->PgFormulario->datos_por_usuario( $this->usuario_id ) > $this->config->limite_por_usuario ) //Verifico si hay límite de envíos por usuario
		{
			return $this->limite_por_usuario();
		}
		else
		{
			return $this->formulario();
		}/**/
	}

	private function formulario()
	{
		$pre = '';
		$elementos = array();
		$fields = array();

		foreach($this->campos AS $campo)
		{
			$c = $this->build_campo( $campo );
			if( $c['index'] !== 0)
			{
				//Lleno los campos
				$elementos[$c['index']] = $c['elemento'];
				//Lleno las reglas de validación para el modelo
				$fields[$c['index']] = $c['reglas'];
			}
			else
				array_push( $elementos, $c['elemento'] );
		}

		//$elementos['ajax'] = array('type' => 'hidden', 'value' => 'custom');

		$botones = array(
		    'send'=>array(
				'type'=>'submit',
				'label'=>$this->config->mensaje_boton,
			),
		);

		$config = array(
			'class' => 'form-horizontal', 
			'enctype' => 'multipart/form-data', 
			'activeForm' => array(
				'id' => 'custom-form', 
				'enableAjaxValidation'=>true,
				'enableClientValidation'=>true,
    			'errorMessageCssClass' => 'alert alert-error', 
			),
			'showErrors' => true, 
			'elements' => $elementos, 
			'buttons' => $botones
		);

		//Defino el modelo con los campos (y sus respectivas reglas de validación)
		$model = new CustomForm( $fields );
		//Creo el formulario con la configuración y el modelo
		$form = new MyForm( $config, $model );

		$this->performAjaxValidation($model);

		if( isset($_POST['CustomForm']) )
		{
			//Verificar si vienen campos de usuario para actualizar (Pendiente)
			$model->attributes = $_POST['CustomForm'];
			if( $model->validate() )
			{
				foreach( $model->attributes as $attr => $value )
				{
					if( substr($attr, 0, 4) === 'file' )
					{
						$model->$attr = CUploadedFile::getInstance($model, $attr);
						$dir = Yii::getPathOfAlias('webroot').'/uploads/'.date('Y').'/'.date('m').'/';
						if( !is_dir($dir) )
							mkdir($dir, 0755, true);
						if( $model->$attr->saveAs( $dir . $model->$attr->name ) )
							$model->$attr = '/uploads/'.date('Y').'/'.date('m').'/'.$model->$attr->name;
						else
							$model->$attr = null;
					}
				}
				//$u_id = Yii::app()->user->getState('usuario_id');
				//$u = Usuario::model()->findByPk($u_id);
				$enviado_a = false;

				//Verificar si se debe enviar por correo
				if( !is_null($this->config->correo) )
				{
					Yii::app()->crugemailer->enviar_datos_form($this->config->correo, $u, $model);
					//Si se envía el correo se agrega a la BD
					$enviado_a = $this->config->correo;
				}
				
				//Aquí almaceno el envío y sus datos
				$ef = new EnvioFormulario;

				if( $ef->guardar_envio( $this->config->id, $model, $enviado_a ) )
				{
					return $this->config->mensaje_envio;
				}
				else
				{
					$pre = '<p>Occurió un error guardando la información</p>';
					//print_r($ef->getErrors());exit();
				}

			}
			
		}

		$custom_css = cs()->registerCss('form_custom_css', $this->config->custom_css);
		$custom_js = cs()->registerScript('form_custom_js', $this->config->custom_js, CClientScript::POS_READY);

		//$model->validatorList->add($newValidator);
		//print_r($model->validatorList);exit();
		return $pre . $form->render();
	}

	private function build_campo( $campo )
	{
		$config 	= $this->configuracion_campo( $campo->tipo_campo_id );
		$datos 		= unserialize($campo->parametros);
		$parametros = unserialize($config->parametros);
		$index 		= 0;
		$reglas		= array();

		if( !is_array($datos) ) return false;
		if( !is_array($parametros) ) return false;

		if( in_array( 'no-form', $parametros ) )
		{
			$html  = '<' . $config->etiqueta;
			$html .= $this->render_params( $parametros, $datos, $noform );
			$html .= '>';
			//Bloque de contenido
			if( in_array( 'texto', $parametros ) && array_key_exists( 'texto', $datos ) )
				$html .= $datos['texto'];
			if( in_array( 'contenido', $parametros ) && array_key_exists( 'contenido', $datos ) )
				$html .= $datos['contenido'];
			//Cierre de etiqueta
			$html .= '</' . $config->etiqueta . '>';
			if( in_array( 'nivel', $parametros ) && array_key_exists( 'nivel', $datos ) )
				$html = str_replace('h*', 'h'.$datos['nivel'], $html);

			$element = $html;
		}
		else
		{
			$index = $campo->nombre;
			$element['type'] = $config->tipo;

			$reglas = $this->load_rules( $parametros, $datos );
			$params = $this->load_params($parametros, $datos);

			$element = array_merge($element, $params);

			if( $campo->etiqueta != NULL)
				$element['label'] = $campo->etiqueta;
			if($campo->requerido)
			{
				$element['required'] = 'required';
				$reglas['required'] = true;
			} 
			if($campo->ayuda)
				$element['title'] = $campo->ayuda;
			if( isset($datos['elementos']) )
				$element['items'] = $datos['elementos'];
			if( in_array( 'placeholder', $parametros ) && array_key_exists( 'placeholder', $datos ) )
				$element['placeholder'] =  $datos['placeholder'];
			if( $config->tipo == 'checkboxlist' || $config->tipo == 'radiolist' )
			{
				$element['labelOptions'] = array('style' => 'display: inline;');
				$element['separator'] = '';
				$element['template'] = '<span class="option">{input} {label}</span>';
				/*
				Pilas, pendiente la opción de columnas de los check y radio
				if( in_array( 'columnas', $parametros ) && array_key_exists( 'columnas', $datos ) )

					
				/**/
			}
			if( $config->tipo == 'dropdownlist' )
			{
				$element['prompt'] = 'Seleccione una opción';
			}

		}

		return array('index' => $index, 'elemento' => $element, 'reglas' => $reglas);
		
	}

	private function configuracion_campo( $tipo_campo_id )
	{
		foreach( $this->tipos_de_campo as $tipo_de_campo )
		{
			if( $tipo_de_campo->id == $tipo_campo_id ) return $tipo_de_campo;
		}
		return false;
	}

	private function limite_por_usuario()
	{
		$mensaje = '<p>Hola, Pepito Pérez.</p>';
		$mensaje .= '<p>Ya has participado de de esta actividad.</p>';

		return $mensaje;
	}

	private function limite()
	{
		$mensaje = '<p>Lo sentimos, este formulario ha alcanzado el límite de envíos.</p>';
		$mensaje .= '<p>Te invitamos a seguir navegando por nuestro sitio, conocer nuestros <a href="'.bu('programas').'">programas</a> o las <a href="'.bu('especiales').'">transmisiones especiales</a> que hemos realizado.</p>';
		$mensaje .= $this->config->mensaje_limite;
		return $mensaje;
	}

	private function previo()
	{
		/*
		$EDate	= $this->config->fecha_apertura;
		$TDay 	= strtotime($EDate);
		$Today  = time();
		$Count 	= ($TDay - $Today)/(60*60*24);//días
		$txt 	= 'días';

		if($Count <= 1)
		{
			$Count  = ($TDay-$Today)/(60*60);//horas
			$txt = 'horas';
		}
		if($Count <= 1)
		{
			$Count  = ($TDay-$Today)/60;//minutos
			$txt = 'minutos';
		}

		$Count = round($Count); 
		if($Count == 1)
			$txt = substr($txt, 0, -1);
		/**/

		$mensaje = '<p>Este formulario estará disponible a partir del ';
		//$mensaje .= $Count . ' ' . $txt . '.';
		$mensaje .= $this->config->fecha_apertura . '</p>' . PHP_EOL;
		$mensaje .= $this->config->mensaje_apertura;

		return $mensaje;
	}

	private function posterior()
	{
		/*
		$EDate  = $this->config->fecha_cierre;
		$TDay = strtotime($EDate);
		$Today  = time();
		$Count  = ($Today - $TDay)/60;//minutos
		$txt = 'minutos';
		
		if($Count >= 60)
		{
			$Count  = ($Today - $TDay)/(60*60);//horas
			$txt = 'horas';
		}
		if($Count >= 24)
		{
			$Count = ($Today - $TDay)/(60*60*24);//días	
			$txt = 'días';
		}

		$Count = round($Count); 
		if($Count == 1)
			$txt = substr($txt, 0, -1);
		/**/
			
		//$mensaje = $this->config->mensaje_cierre;
		$mensaje = '<p>Lo sentimos, este formulario ya no está disponible.</p>';
		$mensaje .= '<p>Te invitamos a seguir navegando por nuestro sitio, conocer nuestros <a href="'.bu('programas').'">programas</a> o las <a href="'.bu('especiales').'">transmisiones especiales</a> que hemos realizado.</p>';
		//$mensaje .= $Count . ' ' . $txt . '.';

		return $mensaje;
	}

	private function render_params( $parametros, $datos, $noform = false )
	{
		$html = '';
		if( $noform )
		{
			if( in_array( 'placeholder', $parametros ) && array_key_exists( 'placeholder', $datos ) )
				$html .= ' placeholder="' . $datos['placeholder'] .'"';
			if( in_array( 'data-minlength', $parametros ) && array_key_exists( 'data-minlength', $datos ) )
				$html .= ' data-minlength="' . $datos['data-minlength'] .'"';
			if( in_array( 'autocomplete', $parametros ) && array_key_exists( 'autocomplete', $datos ) )
				$html .= ' autocomplete="' . $datos['autocomplete'] .'"';
			if( in_array( 'min', $parametros ) && array_key_exists( 'min', $datos ) )
				$html .= ' min="' . $datos['min'] .'"';
			if( in_array( 'max', $parametros ) && array_key_exists( 'max', $datos ) )
				$html .= ' max="' . $datos['max'] .'"';
			if( in_array( 'step', $parametros ) && array_key_exists( 'step', $datos ) )
				$html .= ' step="' . $datos['step'] .'"';
			if( in_array( 'maxlength', $parametros ) && array_key_exists( 'maxlength', $datos ) )
				$html .= ' maxlength="' . $datos['maxlength'] .'"';
			if( in_array( 'multiple', $parametros ) && array_key_exists( 'multiple', $datos ) )
				$html .= ' multiple="' . $datos['multiple'] .'"';
			if( in_array( 'accept', $parametros ) && array_key_exists( 'accept', $datos ) )
				$html .= ' accept="' . $datos['accept'] .'"';
			if( in_array( 'data-min', $parametros ) && array_key_exists( 'data-min', $datos ) )
				$html .= ' data-min="' . $datos['data-min'] .'"';
			if( in_array( 'data-max', $parametros ) && array_key_exists( 'data-max', $datos ) )
				$html .= ' data-max="' . $datos['data-max'] .'"';
			if( in_array( 'data-min-size', $parametros ) && array_key_exists( 'data-min-size', $datos ) )
				$html .= ' data-min-size="' . $datos['data-min-size'] .'"';
			if( in_array( 'data-min-size', $parametros ) && array_key_exists( 'data-min-size', $datos ) )
				$html .= ' data-min-size="' . $datos['data-min-size'] .'"';
			if($campo->requerido) 
				$html .= ' required';
		}//if( !$noform )
		if( in_array( 'alineacion', $parametros ) && array_key_exists( 'alineacion', $datos ) )
			$html .= ' style="text-align: ' . $datos['alineacion'] .';"';
		if( in_array( 'clase', $parametros ) && array_key_exists( 'clase', $datos ) )
			if($datos['clase'] != NULL) $html .= ' class="' . $datos['clase'] .'"';

		return $html;
	}//render_params

	private function load_params( $parametros, $datos )
	{
		$rules = array();
		
		if( in_array( 'autocomplete', $parametros ) && array_key_exists( 'autocomplete', $datos ) )
			$rules['autocomplete'] = $datos['autocomplete'];
		if( in_array( 'step', $parametros ) && array_key_exists( 'step', $datos ) )
			$rules['step'] = $datos['step'];
		if( in_array( 'data-minlength', $parametros ) && array_key_exists( 'data-minlength', $datos ) )
			$rules['min'] = $datos['data-minlength'];
		if( in_array( 'min', $parametros ) && array_key_exists( 'min', $datos ) )
			$rules['min'] = $datos['min'];
		if( in_array( 'max', $parametros ) && array_key_exists( 'max', $datos ) )
			$rules['max'] = $datos['max'];
		if( in_array( 'maxlength', $parametros ) && array_key_exists( 'maxlength', $datos ) )
			$rules['maxlength'] = $datos['maxlength'];
		if( in_array( 'minlength', $parametros ) && array_key_exists( 'minlength', $datos ) )
			$rules['minlength'] = $datos['minlength'];
		/*if( in_array( 'data-min', $parametros ) && array_key_exists( 'data-min', $datos ) )
			$rules['min'] = $datos['data-min'];
		if( in_array( 'data-max', $parametros ) && array_key_exists( 'data-max', $datos ) )
			$rules['max'] = $datos['data-max'];/**/
		if( in_array( 'data-min-size', $parametros ) && array_key_exists( 'data-min-size', $datos ) )
			$rules['data-min-size'] = $datos['data-min-size'];
		if( in_array( 'data-max-size', $parametros ) && array_key_exists( 'data-max-size', $datos ) )
			$rules['data-max-size'] = $datos['data-max-size'];
		if( in_array( 'accept', $parametros ) && array_key_exists( 'accept', $datos ) )
			$rules['data-accept'] = $datos['accept'];
		if( in_array( 'multiple', $parametros ) && array_key_exists( 'multiple', $datos ) )
			$rules['multiple'] = $datos['multiple'];

		return $rules;
	}//load_params

	private function load_rules( $parametros, $datos )
	{
		$rules = array();
		
		if( in_array( 'data-minlength', $parametros ) && array_key_exists( 'data-minlength', $datos ) )
			$rules['length']['min'] = $datos['data-minlength'];
		if( in_array( 'min', $parametros ) && array_key_exists( 'min', $datos ) )
			if( is_int($datos['min']) ) $rules['length']['min'] = $datos['min'];
		if( in_array( 'max', $parametros ) && array_key_exists( 'max', $datos ) )
			if( is_int($datos['max']) ) $rules['length']['max'] = $datos['max'];
		if( in_array( 'maxlength', $parametros ) && array_key_exists( 'maxlength', $datos ) )
			$rules['length']['max'] = $datos['maxlength'];
		if( in_array( 'minlength', $parametros ) && array_key_exists( 'minlength', $datos ) )
			$rules['length']['min'] = $datos['minlength'];
		if( in_array( 'data-min', $parametros ) && array_key_exists( 'data-min', $datos ) )
			$rules['length']['min'] = $datos['data-min'];
		if( in_array( 'data-max', $parametros ) && array_key_exists( 'data-max', $datos ) )
			$rules['length']['max'] = $datos['data-max'];
		if( in_array( 'data-min-size', $parametros ) && array_key_exists( 'data-min-size', $datos ) )
			$rules['file']['minSize'] = $datos['data-min-size'];
		if( in_array( 'data-max-size', $parametros ) && array_key_exists( 'data-max-size', $datos ) )
			$rules['file']['maxSize'] = $datos['data-max-size'];
		if( in_array( 'data-max-files', $parametros ) && array_key_exists( 'data-max-files', $datos ) )
			$rules['file']['maxFiles'] = $datos['data-max-files'];
		if( in_array( 'accept', $parametros ) && array_key_exists( 'accept', $datos ) )
			$rules['file']['types'] = $datos['accept'];

		return $rules;
	}//load_rules

	public function mensaje_registro()
	{
		$html = '<p class="lead text-center">Hola, debes registrarte para participar.</p>';
		//$html .= '<div class="span6 offset3">';
		$html .= '<a class="btn-registro btn btn-primary btn-lg btn-block" href="/tm/usuario/registro">Registrarme</a>';
		$html .= '<a class="btn-login btn btn-link btn-block" href="/tm/usuario">Ya estoy registrado</a>';
		Yii::app()->user->setFlash('backto', Yii::app()->request->url );
		//$html .= '</div>';
		return $html;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax'])/* && $_POST['ajax']==='custom'/**/)
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
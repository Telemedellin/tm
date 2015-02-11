<?php

/**
 * RegistroForm class.
 * RegistroForm is the data structure for keeping
 */
class RegistroForm extends CFormModel
{
	public $correo;
	public $repetir_correo;
	public $contrasena;
	public $repetir_contrasena;
	public $nombres;
	public $apellidos;
	public $sexo;
	public $tipo_documento;
	public $documento;
	public $mes;
	public $dia;
	public $anio;
	public $nacimiento;
	public $nivel_educacion_id;
	public $ocupacion_id;
	public $telefono_fijo;
	public $celular;
	public $pais_id;
	public $region_id;
	public $ciudad_id;
	public $barrio_id;
	public $cableoperador_id;
	public $verifyCode;
	public $terminos;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('correo', 'required'),
			array(
				'contrasena, repetir_contrasena, nombres, apellidos, sexo, tipo_documento, documento, mes, dia, anio, nivel_educacion_id, ocupacion_id, telefono_fijo, pais_id, region_id, ciudad_id, verifyCode, terminos', 
				'required', 
				'on' => 'insert', 
				'message'=>'Por favor verifica que el campo esté llenado correctamente.'
			),
			array('contrasena, repetir_contrasena', 'length', 'min'=>7, 'max'=>40),
            array('repetir_contrasena', 'compare', 'compareAttribute' => 'contrasena'),
            array('repetir_correo', 'compare', 'compareAttribute' => 'correo', 'on' => 'update'),
			array('correo', 'email'),
			array('tipo_documento, documento, mes, dia, anio, nivel_educacion_id, ocupacion_id, celular, pais_id, region_id, ciudad_id, barrio_id, cableoperador_id', 'numerical', 'integerOnly'=>true),
			array('verifyCode', 'ext.validators.AjaxCaptchaValidator', 'allowEmpty' => !Yii::app()->user->isGuest || !CCaptcha::checkRequirements(), 'on' => 'insert', 'message' => 'Código equivocado'), 
			array('terminos', 'boolean'), 
			/*array('correo', 'unique', 'className' => 'CrugeStoredUser', 'attributeName' => 'email', 'message'=>"El {attribute} \"{value}\" Ya se encuentra registrado"),/**/
			array('correo, repetir_correo, contrasena, repetir_contrasena, nombres, apellidos, sexo, tipo_documento, documento, mes, dia, anio, nacimiento, nivel_educacion_id, ocupacion_id, telefono_fijo, celular, pais_id, region_id, ciudad_id, barrio_id, cableoperador_id, verifyCode, terminos', 'safe'),
		); 
	}

	/*
	public function getAttribute($label="username"){
		$array = $this->attributeLabels();
		if(array_key_exists($label, $array)){
			return $array[$label];
		}
		else{
			return "No existe el atributo";
		}
	}
	/**/

	public function getTooltip($label){
		$array = $this->attributeTooltips();
		if(array_key_exists($label, $array)){
			return $array[$label];
		}
		else{
			return "No existe el atributo";
		}
	}	

	public function attributeTooltips(){
		return array(
			'documento'=>'Ingresa tu número de documento sin espacios, guiones o puntos',
		);		
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'correo'=>'Correo electrónico',
			'repetir_correo'=>'Por seguridad, repite tu correo',
			'contrasena'=>'Contraseña',
			'repetir_contrasena'=>'Por seguridad, repite tu contraseña',
			'nombres'=>'Nombres',
			'apellidos'=>'Apellidos',
			'sexo'=>'Sexo',
			'tipo_documento'=>'Tipo de documento',
			'documento'=>'Número de documento de identidad',
			'mes'=>'Mes',
			'dia'=>'Día',
			'anio'=>'Año',
			'nacimiento'=>'Fecha de nacimiento',
			'nivel_educacion_id'=>'Nivel de educación',
			'ocupacion_id'=>'Ocupación',
			'telefono_fijo'=>'Teléfono fijo',
			'celular'=>'Teléfono celular',
			'pais_id'=>'País',
			'region_id'=>'Region',
			'ciudad_id'=>'Ciudad',
			'barrio_id'=>'Barrio',
			'cableoperador_id' => 'Cableoperador', 
			'verifyCode'=>'Por favor ingrese los caracteres o digitos que vea en la imagen', 
			'terminos'=>'Reconozco que he leído y acepto los términos y condiciones', 
		);
	}

	public function getAnios()
	{
		$anios = array();
		$current_year = date('Y');
		$noventa_antes = date('Y')-90;
		for($i = $noventa_antes; $i <= $current_year-5; $i++)
		{
			$anios[$i] = $i;
		}
		return $anios;
	}

	public function getDias()
	{
		$dias = array();
		for($i = 1; $i <= 31; $i++)
		{
			$dias[$i] = $i;
		}
		return $dias;
	}

	public function getMeses()
	{
		return array(
			'1' => 'Enero',
			'2' => 'Febrero',
			'3' => 'Marzo', 
			'4' => 'Abril', 
			'5' => 'Mayo', 
			'6' => 'Junio', 
			'7' => 'Julio', 
			'8' => 'Agosto', 
			'9' => 'Septiembre', 
			'10' => 'Octubre', 
			'11' => 'Noviembre', 
			'12' => 'Diciembre', 
		);
	}
}
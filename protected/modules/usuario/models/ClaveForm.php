<?php

/**
 * ClaveForm class.
 * ClaveForm is the data structure for keeping
 */
class ClaveForm extends CFormModel
{
	public $correo;
	public $contrasena;
	public $repetir_contrasena;
	public $terminos;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// Required fields
			array(
				'correo, contrasena, terminos', 
				'required', 
				'message' => 'Por favor verifica que el campo esté llenado correctamente.'
			),
			array('contrasena, repetir_contrasena', 'required', 'on' => 'insert'),
            array('contrasena, repetir_contrasena', 'length', 'min'=>7, 'max'=>40),
            array('repetir_contrasena', 'compare', 'compareAttribute' => 'contrasena'),
			array('correo', 'email'),
			array('terminos', 'boolean'), 
			array('correo, contrasena, repetir_contrasena, terminos', 'safe', 'on' => 'search'),
		); 
	}

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
			'contrasena' => 'La contraseña debería tener letras, números y caracteres especiales',
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
			'contrasena'=>'Contraseña',
			'repetir_contrasena'=>'Por seguridad, repite tu contraseña',
			'terminos'=>'Reconozco que he leído y acepto los términos y condiciones', 
		);
	}

}
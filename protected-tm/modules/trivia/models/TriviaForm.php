<?php

/**
 * TriviaForm class.
 * TriviaForm is the data structure for keeping
 */
class TriviaForm extends CFormModel
{
	public $pregunta;
	public $respuesta;
	
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// Required fields
			array('pregunta, respuesta', 'required'),
			array('pregunta, respuesta', 'numerical', 'integerOnly' => true),
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
			'pregunta'=>'Preguna',
			'respuesta'=>'Respuesta',
		);
	}

}
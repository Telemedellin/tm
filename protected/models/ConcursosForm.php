<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ConcursosForm extends CFormModel
{
	public $id;
	public $nombre;
	public $texto;
	public $imagen;
	public $miniatura;
	public $formulario;
	public $destacado;
	public $estado;
	
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('nombre, texto', 'required'),
			array('imagen, miniatura, formulario', 'length', 'max'=>255),
			array('estado, destacado', 'numerical', 'integerOnly'=>true)
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'nombre' => 'Título',
			'destacado' => 'Destacado',
			'texto' => 'Texto',
			'imagen' => 'Imagen',
			'miniatura' => 'Imagen Miniatura',
			'formulario' => 'Formulario (ID de JotForm)',
			'estado' => 'Publicado',
		);
	}

}
<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class NovedadesForm extends CFormModel
{
	public $id;
	public $nombre;
	public $entradilla;
	public $texto;
	public $enlace;
	public $imagen;
	public $imagen_mobile;
	public $miniatura;
	public $posicion;
	public $destacado;
	public $estado;
	
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('nombre, entradilla', 'required'),
			array('enlace, imagen, imagen_mobile, miniatura', 'length', 'max'=>255),
			array('texto', 'safe'),
			array('posicion, estado, destacado', 'numerical', 'integerOnly'=>true)
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
			'entradilla' => 'Entradilla',
			'texto' => 'Texto',
			'enlace' => 'Enlace externo (Opcional)',
			'imagen' => 'Imagen',
			'imagen_mobile' => 'Imagen (Móvil)',
			'miniatura' => 'Imagen Miniatura',
			'posicion' => 'Posición',
			'estado' => 'Estado',
		);
	}

}
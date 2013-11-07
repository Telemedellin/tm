<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class EspecialesForm extends CFormModel
{
	public $id;
	public $nombre;
	public $resena;
	public $lugar;
	public $presentadores;
	public $imagen;
	public $miniatura;
	public $destacado;
	public $estado;
	
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('nombre, resena', 'required'),
			array('lugar, presentadores, imagen, miniatura', 'length', 'max'=>255),
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
			'resena' => 'Reseña',
			'lugar' => 'Lugar',
			'presentadores' => 'Presentadores',
			'imagen' => 'Imagen',
			'miniatura' => 'Imagen Miniatura',
			'estado' => 'Publicado',
		);
	}

}
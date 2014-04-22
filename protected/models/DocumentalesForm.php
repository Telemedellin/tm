<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class DocumentalesForm extends CFormModel
{
	public $id;
	public $nombre;
	public $sinopsis;
	public $meta_descripcion;
	public $duracion;
	public $anio;
	public $imagen;
	public $imagen_mobile;
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
			array('nombre, sinopsis, duracion, anio', 'required'),
			array('imagen, imagen_mobile, miniatura', 'length', 'max'=>255),
			array('meta_descripcion', 'length', 'max'=>200),
			array('duracion, anio, estado, destacado', 'numerical', 'integerOnly'=>true)
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
			'sinopsis' => 'Sinopsis',
			'meta_descripcion' => 'Meta descripción',
			'duracion' => 'Duración',
			'anio' => 'Año',
			'imagen' => 'Imagen',
			'imagen_mobile' => 'Imagen (Móvil)',
			'miniatura' => 'Imagen Miniatura',
			'estado' => 'Publicado',
		);
	}

}
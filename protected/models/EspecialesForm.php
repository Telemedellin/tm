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
	public $meta_descripcion;
	public $lugar;
	public $presentadores;
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
			array('nombre, resena', 'required'),
			array('lugar, presentadores, imagen, imagen_mobile, miniatura', 'length', 'max'=>255),
			array('meta_descripcion', 'length', 'max'=>200),
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
			'meta_descripcion' => 'Meta descripción',
			'lugar' => 'Lugar (Opcional)',
			'presentadores' => 'Presentadores (Opcional)',
			'imagen' => 'Imagen',
			'imagen_mobile' => 'Imagen (Móvil)',
			'miniatura' => 'Imagen Miniatura',
			'estado' => 'Publicado',
		);
	}

}
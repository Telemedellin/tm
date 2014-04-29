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
	public $meta_descripcion;
	public $imagen;
	public $imagen_mobile;
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
			array('imagen, imagen_mobile, miniatura, formulario', 'length', 'max'=>255),
			array('meta_descripcion', 'length', 'max'=>200),
			array('formulario, estado, destacado', 'numerical', 'integerOnly'=>true)
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
			'meta_descripcion' => 'Meta descripción',
			'imagen' => 'Imagen',
			'imagen_mobile' => 'Imagen (Móvil)',
			'miniatura' => 'Imagen Miniatura',
			'formulario' => 'Formulario (ID de JotForm)',
			'estado' => 'Publicado',
		);
	}

}
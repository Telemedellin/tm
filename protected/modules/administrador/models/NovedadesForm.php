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
	public $comentarios;
	public $estado;
	
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('nombre, entradilla, imagen, miniatura', 'required'),
			array('enlace, imagen, imagen_mobile, miniatura', 'length', 'max'=>255),
			array('texto', 'safe'),
			array('posicion, estado, destacado, comentarios', 'numerical', 'integerOnly'=>true)
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
			'posicion' => 'Posición entradilla',
			'comentarios' => 'Permitir comentarios',
			'estado' => 'Estado',
		);
	}

	public function guardar()
	{
		$dir = $this->imageRoute;
		$image_base = Yii::getPathOfAlias('webroot').'/images/';
		if($this->validate()){
			if( isset($this->id) ) //Actualizando
				$pagina 				= Pagina::model()->findByPk($this->id);
			else //Nuevo registro
				$pagina 				= new Pagina;
			$transaccion 				= $pagina->dbConnection->beginTransaction();
			$pagina->micrositio_id 		= 2; //Novedades
			$pagina->tipo_pagina_id 	= 3; //Novedad
			$pagina->nombre				= $this->nombre;
			$pagina->clase 				= NULL;
			$pagina->estado 			= $this->estado;
			$pagina->destacado			= $this->destacado;
			
			if($this->imagen != $pagina->background)
			{
				if( file_exists( $image_base . $pagina->background) )
					@unlink( $image_base . $pagina->background );
				$pagina->background 	= $dir . $this->imagen;
			}
			if($this->imagen_mobile != $pagina->background_mobile)
			{
				if( file_exists( $image_base . $pagina->background_mobile) )
					@unlink( $image_base . $pagina->background_mobile );
				$pagina->background_mobile 	= $dir . $this->imagen_mobile;
			}
			if($this->miniatura != $pagina->miniatura)
			{
				if( file_exists( $image_base . $pagina->miniatura) )
					@unlink( $image_base . $pagina->miniatura );
				$pagina->miniatura 	= $dir . $this->miniatura;
			}
			
			if( !$pagina->save(false) ) $transaccion->rollback();
				$pagina_id = $pagina->getPrimaryKey();

			if( isset($this->id) ) //Actualizando
				$pgAB = PgArticuloBlog::model()->findByAttributes(array('pagina_id' => $pagina_id));
			else //Nuevo registro
				$pgAB = new PgArticuloBlog;
			$pgAB->pagina_id 	= $pagina_id;
			$pgAB->entradilla 	= $this->entradilla;
			$pgAB->texto 		= $this->texto;
			$pgAB->enlace 		= $this->enlace;
			$pgAB->comentarios 	= $this->comentarios;
			$pgAB->posicion 	= $this->posicion;
			$pgAB->estado 		= ($this->estado)?1:0;
				
			if( !$pgAB->save(false) )
			{
				$transaccion->rollback();
				return false;
			}
			else
			{
				$transaccion->commit();
				$this->id = $pagina_id;
				return true;
			}
			
		}//if($this->validate())
		else
		{
			return false;
		}
	}

	public function set_fields($pagina)
	{
		if(!$pagina) return false;
		$this->nombre 		= $pagina->nombre;
		$this->entradilla 	= $pagina->pgArticuloBlogs->entradilla;
		$this->texto 		= $pagina->pgArticuloBlogs->texto;
		$this->enlace 		= $pagina->pgArticuloBlogs->enlace;
		$this->imagen 		= $pagina->background;
		$this->imagen_mobile= $pagina->background_mobile;
		$this->miniatura 	= $pagina->miniatura;
		$this->posicion 	= $pagina->pgArticuloBlogs->posicion;
		$this->comentarios 	= $pagina->pgArticuloBlogs->comentarios;
		$this->estado 		= $pagina->estado;
		$this->destacado 	= $pagina->destacado;
		return true;
	}

	public static function getImageRoute()
	{
		return 'novedades/' . date('Y') . '/' . date('m') . '/';
	}

}
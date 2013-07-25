<?php

/**
 * This is the model class for table "pagina".
 *
 * The followings are the available columns in table 'pagina':
 * @property string $id
 * @property string $revision_id
 * @property string $usuario_id
 * @property string $micrositio_id
 * @property string $tipo_pagina_id
 * @property string $nombre
 * @property integer $url_id
 * @property string $creado
 * @property string $modificado
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Micrositio[] $micrositios
 * @property Revision $revision
 * @property Usuario $usuario
 * @property Micrositio $micrositio
 * @property TipoPagina $tipoPagina
 * @property PgPrograma[] $pgProgramas
 */
class Pagina extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pagina the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pagina';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario_id, micrositio_id, tipo_pagina_id, nombre, url_id, creado, estado', 'required'),
			array('estado, url_id', 'numerical', 'integerOnly'=>true),
			array('revision_id, usuario_id, url_id, micrositio_id, tipo_pagina_id, creado, modificado', 'length', 'max'=>10),
			array('nombre', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, revision_id, usuario_id, micrositio_id, tipo_pagina_id, nombre, url_id, creado, modificado, estado', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'micrositios' => array(self::HAS_MANY, 'Micrositio', 'pagina_id'),
			'revision' => array(self::BELONGS_TO, 'Revision', 'revision_id'),
			'usuario' => array(self::BELONGS_TO, 'Usuario', 'usuario_id'),
			'micrositio' => array(self::BELONGS_TO, 'Micrositio', 'micrositio_id'),
			'tipoPagina' => array(self::BELONGS_TO, 'TipoPagina', 'tipo_pagina_id'),
			'pgProgramas' => array(self::HAS_ONE, 'PgPrograma', 'pagina_id'),
			'pgArticuloBlogs' => array(self::HAS_ONE, 'PgArticuloBlog', 'pagina_id'),
			'pgGenericaSts' => array(self::HAS_ONE, 'PgGenericaSt', 'pagina_id'),
			'url' => array(self::BELONGS_TO, 'Url', 'url_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'revision_id' => 'Revision',
			'usuario_id' => 'Usuario',
			'micrositio_id' => 'Micrositio',
			'tipo_pagina_id' => 'Tipo Pagina',
			'nombre' => 'Nombre',
			'url_id' => 'Slug',
			'creado' => 'Creado',
			'modificado' => 'Modificado',
			'estado' => 'Estado',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('revision_id',$this->revision_id,true);
		$criteria->compare('usuario_id',$this->usuario_id,true);
		$criteria->compare('micrositio_id',$this->micrositio_id,true);
		$criteria->compare('tipo_pagina_id',$this->tipo_pagina_id,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('url_id',$this->url_id,true);
		$criteria->compare('creado',$this->creado,true);
		$criteria->compare('modificado',$this->modificado,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function listarPaginas( $micrositio_id, $limite = 20, $offset = 0 )
	{
		if( !$micrositio_id ) return false;
		$c 			= new CDbCriteria;
		$c->select 	= 't.*, tipo_pagina.tabla, url.slug';
		$c->join 	= 'JOIN tipo_pagina ON tipo_pagina.id = t.tipo_pagina_id';
		$c->join 	.= ' JOIN url ON url.id = t.url_id';
		$c->limit 	= $limite;
		$c->offset 	= $offset;
		$c->order 	= 't.creado DESC';
		$c->addCondition( 't.micrositio_id = "' . $micrositio_id . '"' );
		$c->addCondition( 't.estado <> 0' );

		$paginas  	= $this->findAll( $c );

		if( !$paginas ) return false;
		$r = array();
		foreach($paginas as $pagina)
		{
			$tabla 	= $pagina->tipoPagina->tabla;
			$t 		= new $tabla();
			$p 		= $t->findByAttributes( array('pagina_id' => $pagina->id) );
			$r[] 	= array('pagina' => $pagina, 'contenido' => $p);
		}
		if( empty($r) ) return false;

		return $r;

	}

	public function cargarPagina($pagina_id = 0)
	{
		if( !$pagina_id ) return false;
		$c = new CDbCriteria;
		$c->select = 't.*, tipo_pagina.tabla';
		$c->join = 'JOIN tipo_pagina ON tipo_pagina.id = t.tipo_pagina_id';
		$c->addCondition( 't.id = "' . $pagina_id . '"' );
		$c->addCondition( 't.estado <> 0' );
		$pagina  = $this->find( $c );

		if( !$pagina ) return false;

		$tabla = $pagina->tipoPagina->tabla;
		$t = new $tabla();
		$contenido = $t->findByAttributes( array('pagina_id' => $pagina->id) );

		if( !$contenido ) return false;

		$resultado = array(
				'pagina' 	=> $pagina,
				'partial'   => $tabla,
				'contenido' => $contenido,
			);

		return $resultado;
	}

	public function cargarPorUrl($url_id)
	{
		if( !$url_id ) return false;
		
		$c = new CDbCriteria;
		//$c->select = 't.*, tipo_pagina.tabla';
		$c->join = 'JOIN tipo_pagina ON tipo_pagina.id = t.tipo_pagina_id';
		$c->addCondition( 't.url_id = "' . $url_id . '"' );
		$c->addCondition( 't.estado <> 0' );
		$pagina  = $this->with('url')->find( $c );

		$tabla = $pagina->tipoPagina->tabla;
		$t = new $tabla();
		$contenido = $t->findByAttributes( array('pagina_id' => $pagina->id) );

		if( !$contenido ) return false;

		$resultado = array(
				'pagina' 	=> $pagina,
				'partial'   => $tabla,
				'contenido' => $contenido,
			);

		return $resultado;
	}

}
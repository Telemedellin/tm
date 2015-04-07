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
 * @property string $url_id
 * @property string $nombre
 * @property string $clase
 * @property string $background
 * @property string $background_mobile
 * @property string $miniatura
 * @property string $creado
 * @property string $modificado
 * @property integer $estado
 * @property integer $destacado
 *
 * The followings are the available model relations:
 * @property Micrositio[] $micrositios
 * @property Micrositio $micrositio
 * @property Revision $revision
 * @property TipoPagina $tipoPagina
 * @property Url $url
 * @property Usuario $usuario
 * @property PgArticuloBlog[] $pgArticuloBlogs
 * @property PgDocumental[] $pgDocumentals
 * @property PgEspecial[] $pgEspecials
 * @property PgGenericaSt[] $pgGenericaSts
 * @property PgPrograma[] $pgProgramas
 */
class Pagina extends CActiveRecord
{
	private $transaccion;
	protected $oldAttributes;
	public $tipo_pagina;
	public $url_slug;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pagina the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors()
	{
		return array(
			'utilities'=>array(
                'class'=>'application.components.behaviors.Utilities'
            )
		);
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
			array('micrositio_id, tipo_pagina_id, nombre, estado, destacado', 'required'),
			array('estado, usuario_id, url_id, micrositio_id, tipo_pagina_id, destacado', 'numerical', 'integerOnly'=>true),
			array('nombre, clase', 'length', 'max'=>100),
			array('background, background_mobile, miniatura', 'length', 'max'=>255),
			array('meta_descripcion', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, revision_id, usuario_id, micrositio_id, tipo_pagina_id, tipo_pagina, nombre, meta_descripcion, clase, url_id, url_slug, background, background_mobile, miniatura, creado, modificado, estado, destacado', 'safe', 'on'=>'search'),
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
			'micrositio' => array(self::BELONGS_TO, 'Micrositio', 'micrositio_id'),
			'revision' => array(self::BELONGS_TO, 'Revision', 'revision_id'),
			'tipoPagina' => array(self::BELONGS_TO, 'TipoPagina', 'tipo_pagina_id'),
			'url' => array(self::BELONGS_TO, 'Url', 'url_id'),
			'usuario' => array(self::BELONGS_TO, 'Usuario', 'usuario_id'),
			'pgArticuloBlogs' => array(self::HAS_ONE, 'PgArticuloBlog', 'pagina_id'),
			'pgDocumentals' => array(self::HAS_ONE, 'PgDocumental', 'pagina_id'),
			'pgEspecials' => array(self::HAS_ONE, 'PgEspecial', 'pagina_id'),
			'pgGenericaSts' => array(self::HAS_ONE, 'PgGenericaSt', 'pagina_id'),
			'pgFormularioJfs' => array(self::HAS_ONE, 'PgFormularioJf', 'pagina_id'),
			'pgProgramas' => array(self::HAS_ONE, 'PgPrograma', 'pagina_id'),
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
			'url_id' => 'Url',
			'nombre' => 'Nombre',
			'meta_descripcion' => 'Meta descripción',
			'clase' => 'Clase',
			'background' => 'Imagen',
			'background_mobile' => 'Imagen (Móvil)',
			'miniatura' => 'Imagen miniatura',
			'creado' => 'Creado',
			'modificado' => 'Modificado',
			'estado' => 'Publicado',
			'destacado' => 'Destacado',
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

		$criteria = new CDbCriteria;
		$criteria->with = array( 'url', 'tipoPagina' );

		$criteria->compare('id',$this->id);
		$criteria->compare('revision_id',$this->revision_id);
		$criteria->compare('usuario_id',$this->usuario_id);
		$criteria->compare('micrositio_id',$this->micrositio_id);
		$criteria->compare('tipo_pagina_id',$this->tipo_pagina_id);
		$criteria->compare('tipoPagina.id',$this->tipo_pagina);
		$criteria->compare('url_id',$this->url_id);
		$criteria->compare('url.slug',$this->url_slug, true);
		$criteria->compare('t.nombre',$this->nombre,true);
		$criteria->compare('meta_descripcion',$this->meta_descripcion,true);
		$criteria->compare('clase',$this->clase,true);
		$criteria->compare('background',$this->background,true);
		$criteria->compare('background_mobile',$this->background_mobile,true);
		$criteria->compare('miniatura',$this->miniatura,true);
		$criteria->compare('t.creado',$this->creado,true);
		$criteria->compare('t.modificado',$this->modificado,true);
		$criteria->compare('t.estado',$this->estado);
		$criteria->compare('t.destacado',$this->destacado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>25,
			),
		));
	}

	public function listarPaginas( $micrositio_id, $limite = 20, $offset = 0 )
	{
		if( !$micrositio_id ) return false;
		$c 			= new CDbCriteria;
		$c->limit 	= $limite;
		$c->offset 	= $offset;
		$c->order 	= 't.nombre DESC';
		$c->addCondition( 't.micrositio_id = "' . $micrositio_id . '"' );
		$c->addCondition( 't.estado <> 0' );

		$dependencia = new CDbCacheDependency("SELECT GREATEST(MAX(creado), MAX(modificado)) FROM pagina WHERE micrositio_id = $micrositio_id AND estado <> 0");
		$paginas  	= $this->cache(21600, $dependencia)->with('url', 'tipoPagina')->findAll( $c );

		if( !$paginas ) return false;
		$r = array();
		foreach($paginas as $pagina)
		{
			$tabla 	= $pagina->tipoPagina->tabla;
			$t 		= new $tabla();
			$p 		= $t->findByAttributes( array('pagina_id' => $pagina->id), array('condition' => 't.estado <> 0') );
			$r[] 	= array('pagina' => $pagina, 'contenido' => $p);
		}
		if( empty($r) ) return false;

		return $r;

	}

	public function listarNovedades( $limite = 20, $offset = 0 )
	{
		$micrositio_id = 2;
		$c 			= new CDbCriteria;
		$c->limit 	= $limite;
		$c->offset 	= $offset;
		$c->order 	= 't.destacado DESC, t.creado DESC';
		$c->addCondition( 't.micrositio_id = "' . $micrositio_id . '"' );
		$c->addCondition( 't.estado = 2' );

		$dependencia = new CDbCacheDependency("SELECT GREATEST(MAX(creado), MAX(modificado)) FROM pagina WHERE micrositio_id = $micrositio_id AND estado = 2");
		$paginas  	 = $this->cache(21600, $dependencia)->with('url', 'tipoPagina', 'pgArticuloBlogs')->findAll( $c );

		if( !$paginas ) return false;
		return $paginas;
	}

	public function cargarPagina($pagina_id = 0)
	{
		if( !$pagina_id ) return false;
		$c = new CDbCriteria;
		$c->select = 't.*, tipo_pagina.tabla';
		$c->join = 'JOIN tipo_pagina ON tipo_pagina.id = t.tipo_pagina_id';
		$c->addCondition( 't.id = "' . $pagina_id . '"' );
		//$c->addCondition( 't.estado <> 0' );
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

	public function cargarPorMicrositio($micrositio_id = 0)
	{
		if( !$micrositio_id ) return false;
		$c = new CDbCriteria;
		$c->select = 't.*, tipo_pagina.tabla';
		$c->join = 'JOIN tipo_pagina ON tipo_pagina.id = t.tipo_pagina_id';
		$c->addCondition( 't.micrositio_id = "' . $micrositio_id . '"' );
		$c->addCondition( 't.estado <> 0' );
		$c->order 	= 't.nombre ASC';
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
		$c->join = 'JOIN tipo_pagina ON tipo_pagina.id = t.tipo_pagina_id';
		$c->addCondition( 't.url_id = "' . $url_id . '"' );
		$c->addCondition( 't.estado <> 0' );
		$pagina  = $this->with('url')->find( $c );

		$tabla = $pagina->tipoPagina->tabla;
		if( !$tabla ) return false;
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

	protected function beforeDelete()
	{
		$this->transaccion = $this->dbConnection->getCurrentTransaction();
		if($this->transaccion === null)
			$this->transaccion = $this->dbConnection->beginTransaction();
		try
		{
			// 1. Desasignar de los micrositios que la tengan por defecto.
			$micrositios = Micrositio::model()->findAllByAttributes( array('pagina_id' => $this->id) );
			foreach($micrositios as $m)
			{
				$m->pagina_id = NULL;
				$m->save();
			}
			
			// 3.Verifico el tipo de página para ver si tiene una tabla auxiliar
			$tabla 	= $this->tipoPagina->tabla;
			$t 		= new $tabla();
			$contenido = $t->findByAttributes( array('pagina_id' => $this->id) );

			switch($tabla)
			{
				case 'PgPrograma':
					Horario::model()->deleteAllByAttributes( array('pg_programa_id' => $contenido->id) );
					break;
				case 'PgDocumental':
					FichaTecnica::model()->deleteAllByAttributes( array('pg_documental_id' => $contenido->id) );
					break;
				/*case 'Carpeta':
					Carpeta::model()->vaciar_carpeta( $contenido->id );
					break;/**/
				case 'PgFiltro':
					FiltroItem::model()->deleteAllByAttributes( array('pg_filtro_id' => $contenido->id) );
					break;
				case 'PgBloques':
					Bloque::model()->deleteAllByAttributes( array('pg_bloques_id' => $contenido->id) );
					break;
				case 'PgEventos':
					Evento::model()->deleteAllByAttributes( array('pg_eventos_id' => $contenido->id) );
					break;
			}
			// 4. Borro la tabla pg_
			
			//$this->transaccion->commit();
			return parent::beforeDelete();
		}//try
		catch(Exception $e)
		{
		   $this->transaccion->rollback();
		   return false;
		}
	}

	protected function afterDelete()
	{
		// 6. Elimino la URL asociada
		$url = Url::model()->with('micrositiosCount')->findByPk($this->url_id);
		//Verifico que no sea la página por defecto y la url tenga también un micrositio relacionado
		if( $url->micrositiosCount == 1 )
			$url->delete();

		$imagenes = array();
		if( !is_null($this->background) && !empty($this->background) ) 
			$imagenes[] = $this->background;
		if( !is_null($this->background_mobile) && !empty($this->background_mobile) ) 
			$imagenes[] = $this->background_mobile;
		if( !is_null($this->miniatura) && !empty($this->miniatura) ) 
			$imagenes[] = $this->miniatura;
		
		if(isset($imagenes))
			foreach($imagenes as $imagen)
				@unlink( Yii::getPathOfAlias('webroot').'/images/' . $imagen);
		return parent::afterDelete();
	}

	protected function afterFind()
	{
	    $this->oldAttributes = $this->attributes;
	    return parent::afterFind();
	}

	protected function beforeSave()
	{
 
        if($this->isNewRecord)
        {
        	$micrositio= Micrositio::model()->findByPk($this->micrositio_id);
			$url 	   = new Url;
			if($micrositio->seccion->nombre == 'sin-seccion')
				$slug  = $this->slugger($micrositio->nombre).'/'.$this->slugger($this->nombre);
			else
				$slug  = $this->slugger($micrositio->seccion->nombre).'/'.$this->slugger($micrositio->nombre).'/'.$this->slugger($this->nombre);
			$slug 	   = $this->verificarSlug($slug);
			$url->slug = $slug;
			$url->tipo_id 	= 3; //Página
			$url->estado  	= 1;
			if( $url->save() )
				$this->url_id = $url->getPrimaryKey();
			else
				return false;

			$this->usuario_id	= Yii::app()->user->getState('usuario_id');
        	$this->revision_id 	= NULL;
        	$this->creado 		= date('Y-m-d H:i:s');
            if(!$this->estado)
            	$this->estado 	= 0;
        }
        else
        {
            //Crear la revisión
            $this->revision_id 	= NULL;
            $this->modificado	= date('Y-m-d H:i:s');
        }
		return parent::beforeSave();
	}

	protected function afterSave()
	{
		if(!$this->isNewRecord)
		{
			if( isset($this->oldAttributes['nombre']) && $this->nombre != $this->oldAttributes['nombre']){
				$micrositio = Micrositio::model()->findByPk($this->micrositio_id);
				$url = Url::model()->findByPk($this->url_id);
				if($micrositio->seccion->nombre == 'sin-seccion')
					$slug = $this->slugger($micrositio->nombre).'/'.$this->slugger($this->nombre);
				else
					$slug = $this->slugger($micrositio->seccion->nombre).'/'.$this->slugger($micrositio->nombre).'/'.$this->slugger($this->nombre);
				$slug = $this->verificarSlug($slug);
				$url->slug 	= $slug;
				$url->save();
			}

		}
		parent::afterSave();
	}

}
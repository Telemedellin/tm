<?php

/**
 * This is the model class for table "micrositio".
 *
 * The followings are the available columns in table 'micrositio':
 * @property string $id
 * @property string $nombre
 * @property string $seccion_id
 * @property string $usuario_id
 * @property string $url_id
 * @property string $pagina_id
 * @property string $menu_id
 * @property string $background
 * @property string $miniatura
 * @property string $creado
 * @property string $modificado
 * @property integer $estado
 * @property integer $destacado
 *
 * The followings are the available model relations:
 * @property AlbumFoto[] $albumFotos
 * @property AlbumVideo[] $albumVideos
 * @property Menu $menu
 * @property Pagina $pagina
 * @property Seccion $seccion
 * @property Url $url
 * @property Usuario $usuario
 * @property Pagina[] $paginas
 * @property Programacion[] $programacions
 * @property RedSocial[] $redSocials
 */
class Micrositio extends CActiveRecord
{
	private $transaccion;
	protected $oldAttributes;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Micrositio the static model class
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
		return 'micrositio';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, seccion_id, usuario_id, creado, estado, destacado', 'required'),
			array('estado, destacado', 'numerical', 'integerOnly'=>true),
			array('nombre, background, background_mobile, miniatura', 'length', 'max'=>255),
			array('seccion_id, usuario_id, url_id, menu_id', 'length', 'max'=>10),
			array('modificado, pagina_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, seccion_id, usuario_id, url_id, pagina_id, menu_id, background, background_mobile, miniatura, creado, modificado, estado, destacado', 'safe', 'on'=>'search'),
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
			'albumFotos' => array(self::HAS_MANY, 'AlbumFoto', 'micrositio_id', 'on' => 'albumFotos.estado <> 0'),
			'albumVideos' => array(self::HAS_MANY, 'AlbumVideo', 'micrositio_id', 'on' => 'albumVideos.estado <> 0'),
			'menu' => array(self::BELONGS_TO, 'Menu', 'menu_id'),
			'pagina' => array(self::BELONGS_TO, 'Pagina', 'pagina_id'/*, 'on' => 'pagina.estado <> 0'*/),
			'seccion' => array(self::BELONGS_TO, 'Seccion', 'seccion_id'),
			'url' => array(self::BELONGS_TO, 'Url', 'url_id'),
			'usuario' => array(self::BELONGS_TO, 'Usuario', 'usuario_id'),
			'paginas' => array(self::HAS_MANY, 'Pagina', 'micrositio_id', 'order' => 'paginas.nombre ASC', 'having' => 'paginas.tipo_pagina_id <> 3'),
			'programacions' => array(self::HAS_MANY, 'Programacion', 'micrositio_id'),
			'redSocials' => array(self::HAS_MANY, 'RedSocial', 'micrositio_id'),
			'micrositio_x_genero' => array(self::HAS_MANY, 'MicrositioXGenero', 'micrositio_id'), 
			'micrositio_x_relacionado' => array(self::HAS_MANY, 'MicrositioXRelacionado', 'micrositio_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'seccion_id' => 'Sección',
			'usuario_id' => 'Usuario',
			'url_id' => 'Url',
			'pagina_id' => 'Página',
			'menu_id' => 'Menu',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('t.nombre',$this->nombre,true);
		$criteria->compare('seccion_id',$this->seccion_id,true);
		$criteria->compare('usuario_id',$this->usuario_id,true);
		$criteria->compare('url_id',$this->url_id,true);
		$criteria->compare('pagina_id',$this->pagina_id,true);
		$criteria->compare('menu_id',$this->menu_id,true);
		$criteria->compare('background',$this->background,true);
		$criteria->compare('background_mobile',$this->background_mobile,true);
		$criteria->compare('miniatura',$this->miniatura,true);
		$criteria->compare('t.creado',$this->creado,true);
		$criteria->compare('t.modificado',$this->modificado,true);
		$criteria->compare('t.estado',$this->estado);
		$criteria->compare('t.destacado',$this->destacado);

		$criteria->with = array('url');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
	            'defaultOrder'=>'t.estado DESC, t.creado DESC',
        	),
			'pagination'=>array(
				'pageSize'=>25,
			),
		));
	}
	public function listarPorSeccion( $seccion_id )
	{
		if( !$seccion_id ) return false;

		$dependencia = new CDbCacheDependency("SELECT GREATEST(MAX(creado), MAX(modificado)) FROM micrositio WHERE seccion_id = $seccion_id AND estado <> 0");
		return $this->cache(3600, $dependencia)->with('pagina')->findAllByAttributes( array('seccion_id' => $seccion_id), array('condition' => 't.estado = 2', 'order' => 't.nombre ASC') );
	}

	public function cargarPorUrl($url_id)
	{
		if( !$url_id ) return false;
		return $this->findByAttributes( array('url_id' => $url_id), 't.estado <> 0' );
	}

	public function cargarMicrositio($micrositio_id)
	{
		if( !$micrositio_id ) return false;
		return $this->findByPk( $micrositio_id, 't.estado <> 0' );
	}

	public function getDefaultPage( $micrositio_id )
	{
		if( !$micrositio_id ) return false;

		$m = $this->findByPk( $micrositio_id );

		return $m->pagina_id;
	}

	public function asignar_pagina($pagina)
	{
		$this->pagina_id = $pagina->getPrimaryKey();
		if( !$this->save(false) )
			return false;

		//Eliminar URL de página por defecto y asignar la url del micrositio
		$old_purl = $pagina->url_id;
		$pagina->url_id = $this->url_id;
		if( !$pagina->save(false) )
			return false;
		
		if( !Url::model()->deleteByPk($old_purl) )
			return false;
		
		if( !MenuItem::model()->crear_item_inicio($pagina) )
			return false;
		return true;
	}

	protected function beforeDelete()
	{
		$this->transaccion = $this->dbConnection->getCurrentTransaction();
		if($this->transaccion === null)
			$this->transaccion = $this->dbConnection->beginTransaction();
		try
		{
			$this->pagina_id = NULL;
			$this->save(NULL);
			foreach($this->paginas as $pagina)
			{
				$p = Pagina::model()->findByPk($pagina->id);
				$p->delete();
			}
			foreach($this->albumFotos as $albumFoto)
			{
				$af = AlbumFoto::model()->findByPk($albumFoto->id);
				$af->delete();
			}
			foreach($this->albumVideos as $albumVideo)
			{
				$av = AlbumVideo::model()->findByPk($albumVideo->id);
				$av->delete();
			}
			foreach($this->programacions as $programacion)
			{
				$pr = Programacion::model()->findByPk($programacion->id);
				$pr->delete();
			}
			foreach($this->redSocials as $redSocial)
			{
				$r = RedSocial::model()->findByPk($redSocial->id);
				$r->delete();
			}

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
		$this->transaccion = $this->dbConnection->getCurrentTransaction();
		if($this->transaccion === null)
			$this->transaccion = $this->dbConnection->beginTransaction();
		try
		{
			if(!is_null($this->menu_id))
			{
				$menu = Menu::model()->findByPk($this->menu_id);
				$menu->delete();
			}
			$url = Url::model()->findByPk($this->url_id);
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
			$this->transaccion->commit();
		}//try
		catch(Exception $e)
		{
		   $this->transaccion->rollback();
		   return false;
		}
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
        	$seccion = Seccion::model()->findByPk($this->seccion_id);

        	$url 				= new Url;
			$slug 				= $this->slugger($seccion->nombre) . '/' . $this->slugger($this->nombre);
			$slug 				= $this->verificarSlug($slug);
			$url->slug 			= $slug;
			$url->tipo_id 		= 2; //Micrositio
			$url->estado  		= 1;
			$url->save();
			
			$this->url_id 		= $url->getPrimaryKey();
        	$this->usuario_id	= Yii::app()->user->getState('usuario_id');
        	$this->pagina_id 	= NULL;
        	$this->menu_id 		= NULL;
        	$this->creado 		= date('Y-m-d H:i:s');
        }
        else
        {
            $this->modificado	= date('Y-m-d H:i:s');
        }
	    return parent::beforeSave();
	}

	protected function afterSave()
	{
		if($this->isNewRecord)
		{
			$menu = new Menu;
			$menu->nombre = $this->nombre;
			$menu->estado = 1;
			$menu->save();

			$this->menu_id = $menu->getPrimaryKey();

		}
		else
		{
			if( isset($this->oldAttributes['nombre']) && $this->nombre != $this->oldAttributes['nombre']){
				$seccion = Seccion::model()->findByPk($this->seccion_id);

				$url 		= Url::model()->findByPk($this->url_id);
				$slug 		= $this->slugger($seccion->nombre) . '/' . $this->slugger($this->nombre);
				$slug 		= $this->verificarSlug($slug);
				$url->slug 	= $slug;
				$url->save();

				foreach($this->paginas as $pagina)
				{
					$uid 	 = $pagina->url_id;
					$u 		 = Url::model()->findByPk($uid);
					$nslug 	 = $this->slugger($seccion->nombre).'/'.$this->slugger($this->nombre).'/'.$this->slugger($pagina->nombre);
					$nslug 	 = $this->verificarSlug($nslug);
					$u->slug = $nslug;
					$u->save();
				}
			}
		}
		return parent::afterSave();
	}
}
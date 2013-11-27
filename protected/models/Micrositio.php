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
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Micrositio the static model class
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
			array('nombre, seccion_id, usuario_id, url_id, creado, estado, destacado', 'required'),
			array('estado, destacado', 'numerical', 'integerOnly'=>true),
			array('nombre, background, miniatura', 'length', 'max'=>255),
			array('seccion_id, usuario_id, url_id, pagina_id, menu_id', 'length', 'max'=>10),
			array('modificado', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, seccion_id, usuario_id, url_id, pagina_id, menu_id, background, miniatura, creado, modificado, estado, destacado', 'safe', 'on'=>'search'),
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
			'paginas' => array(self::HAS_MANY, 'Pagina', 'micrositio_id', 'order' => 'paginas.nombre ASC'),
			'programacions' => array(self::HAS_MANY, 'Programacion', 'micrositio_id'),
			'redSocials' => array(self::HAS_MANY, 'RedSocial', 'micrositio_id'),
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('seccion_id',$this->seccion_id,true);
		$criteria->compare('usuario_id',$this->usuario_id,true);
		$criteria->compare('url_id',$this->url_id,true);
		$criteria->compare('pagina_id',$this->pagina_id,true);
		$criteria->compare('menu_id',$this->menu_id,true);
		$criteria->compare('background',$this->background,true);
		$criteria->compare('miniatura',$this->miniatura,true);
		$criteria->compare('creado',$this->creado,true);
		$criteria->compare('modificado',$this->modificado,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('destacado',$this->destacado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function listarPorSeccion( $seccion_id )
	{
		if( !$seccion_id ) return false;
		$dependencia = new CDbCacheDependency("SELECT MAX(creado) FROM micrositio WHERE seccion_id = $seccion_id AND estado <> 0");
		return $this->with('pagina')->findAllByAttributes( array('seccion_id' => $seccion_id), array('condition' => 't.estado <> 0', 'order' => 't.nombre ASC') );
	}

	public function cargarPorUrl($url_id)
	{
		if( !$url_id ) return false;
		return $this->with('url', 'seccion', 'redSocials', 'albumVideos', 'paginas')->findByAttributes( array('url_id' => $url_id)/*, 't.estado <> 0'*/ );
	}

	public function cargarMicrositio($micrositio_id)
	{
		if( !$micrositio_id ) return false;
		return $this->with('url', 'seccion', 'redSocials', 'albumVideos', 'paginas')->findByPk( $micrositio_id/*, 't.estado <> 0'*/ );
	}

	public function getDefaultPage( $micrositio_id )
	{
		if( !$micrositio_id ) return false;

		$m = $this->findByPk( $micrositio_id );

		return $m->pagina_id;
	}

	protected function beforeSave()
	{
	    if(parent::beforeSave())
	    {
	        if($this->isNewRecord)
	        {
	        	$this->usuario_id	= Yii::app()->user->id;
	        	$this->pagina_id 	= NULL;
	        	$this->menu_id 		= NULL;
	        	$this->creado 		= date('Y-m-d H:i:s');
	            $this->estado 		= 1;
	        }
	        else
	        {
	            $this->modificado	= date('Y-m-d H:i:s');
	        }
	        return true;
	    }
	    else
	        return false;
	}
}
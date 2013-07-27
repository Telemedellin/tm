<?php

/**
 * This is the model class for table "micrositio".
 *
 * The followings are the available columns in table 'micrositio':
 * @property string $id
 * @property string $nombre
 * @property string $seccion_id
 * @property string $pagina_id
 * @property string $usuario_id
 * @property string $menu_id
 * @property string $background
 * @property integer $url_id
 * @property string $creado
 * @property string $modificado
 * @property integer $estado
 * @property integer $destacado
 *
 * The followings are the available model relations:
 * @property Menu $menu
 * @property Pagina $pagina
 * @property Seccion $seccion
 * @property Usuario $usuario
 * @property Pagina[] $paginas
 * @property Url $url
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
			array('nombre, seccion_id, usuario_id, background, url_id, creado, estado, destacado', 'required'),
			array('estado, url_id, destacado', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>45),
			array('seccion_id, pagina_id, url_id usuario_id, menu_id, creado, modificado', 'length', 'max'=>10),
			array('background', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, seccion_id, pagina_id, usuario_id, menu_id, background, url_id, creado, modificado, estado, destacado', 'safe', 'on'=>'search'),
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
			'menu' => array(self::BELONGS_TO, 'Menu', 'menu_id'),
			'pagina' => array(self::BELONGS_TO, 'Pagina', 'pagina_id'),
			'seccion' => array(self::BELONGS_TO, 'Seccion', 'seccion_id'),
			'usuario' => array(self::BELONGS_TO, 'Usuario', 'usuario_id'),
			'paginas' => array(self::HAS_MANY, 'Pagina', 'micrositio_id'),
			'red_social' => array(self::HAS_MANY, 'RedSocial', 'micrositio_id'),
			'programaciones' => array(self::HAS_MANY, 'Programacion', 'micrositio_id'),
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
			'nombre' => 'Nombre',
			'seccion_id' => 'Seccion',
			'pagina_id' => 'Pagina',
			'usuario_id' => 'Usuario',
			'menu_id' => 'Menu',
			'background' => 'Background',
			'url_id' => 'Slug',
			'creado' => 'Creado',
			'modificado' => 'Modificado',
			'estado' => 'Estado',
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
		$criteria->compare('pagina_id',$this->pagina_id,true);
		$criteria->compare('usuario_id',$this->usuario_id,true);
		$criteria->compare('menu_id',$this->menu_id,true);
		$criteria->compare('background',$this->background,true);
		$criteria->compare('url_id',$this->url_id,true);
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
		return $this->findAllByAttributes( array('seccion_id' => $seccion_id), 't.estado <> 0' );
	}

	public function cargarPorUrl($url_id)
	{
		if( !$url_id ) return false;
		return $this->with('url', 'seccion', 'red_social')->findByAttributes( array('url_id' => $url_id), 't.estado <> 0' );
	}

	public function cargarMicrositio($micrositio_id)
	{
		if( !$micrositio_id ) return false;
		return $this->with('url', 'seccion', 'red_social')->findByPk( $micrositio_id, 't.estado <> 0' );
	}

	public function getDefaultPage( $micrositio_id )
	{
		if( !$micrositio_id ) return false;

		$m = $this->findByPk( $micrositio_id );

		return $m->pagina_id;
	}
}
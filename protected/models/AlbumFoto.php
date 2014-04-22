<?php

/**
 * This is the model class for table "album_foto".
 *
 * The followings are the available columns in table 'album_foto':
 * @property string $id
 * @property string $micrositio_id
 * @property string $url_id
 * @property string $nombre
 * @property string $directorio
 * @property string $creado
 * @property string $modificado
 * @property integer $estado
 * @property integer $destacado
 *
 * The followings are the available model relations:
 * @property Url $url
 * @property Micrositio $micrositio
 * @property Foto[] $fotos
 */
class AlbumFoto extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AlbumFoto the static model class
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
		return 'album_foto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('micrositio_id, url_id, nombre, creado, estado, destacado', 'required'),
			array('estado, destacado', 'numerical', 'integerOnly'=>true),
			array('micrositio_id, url_id', 'length', 'max'=>10),
			array('nombre', 'length', 'max'=>45),
			array('modificado', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, micrositio_id, url_id, nombre, directorio, creado, modificado, estado, destacado', 'safe', 'on'=>'search'),
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
			'url' => array(self::BELONGS_TO, 'Url', 'url_id'),
			'micrositio' => array(self::BELONGS_TO, 'Micrositio', 'micrositio_id'),
			'fotos' => array(self::HAS_MANY, 'Foto', 'album_foto_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'micrositio_id' => 'Micrositio',
			'url_id' => 'Url',
			'nombre' => 'Nombre',
			'directorio' => 'Directorio',
			'creado' => 'Creado',
			'modificado' => 'Modificado',
			'estado' => 'Estado',
			'destacado' => 'Destacado',
		);
	}

	public function behaviors()
	{
		return array(
			'galleryBehavior' => array(
	            'class' => 'ext.galleryManager.GalleryBehavior',
	            'idAttribute' => 'id',
	            'versions' => array(
	                'thumb' => array(
	                    'resize' => array(100, null),
	                )
	            )
	        )
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
		$criteria->compare('micrositio_id',$this->micrositio_id,true);
		$criteria->compare('url_id',$this->url_id,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('directorio',$this->directorio,true);
		$criteria->compare('creado',$this->creado,true);
		$criteria->compare('modificado',$this->modificado,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('destacado',$this->destacado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "video".
 *
 * The followings are the available columns in table 'video':
 * @property string $id
 * @property string $album_video_id
 * @property string $proveedor_video_id
 * @property string $url_id
 * @property string $url_video
 * @property string $nombre
 * @property string $descripcion
 * @property string $duracion
 * @property string $creado
 * @property string $modificado
 * @property integer $estado
 * @property integer $destacado
 *
 * The followings are the available model relations:
 * @property Url $url
 * @property AlbumVideo $albumVideo
 * @property ProveedorVideo $proveedorVideo
 */
class Video extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Video the static model class
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
		return 'video';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('album_video_id, proveedor_video_id, url_id, url_video, nombre, duracion, creado, estado, destacado', 'required'),
			array('estado, destacado', 'numerical', 'integerOnly'=>true),
			array('album_video_id, proveedor_video_id, url_id', 'length', 'max'=>10),
			array('url_video, nombre', 'length', 'max'=>100),
			array('duracion', 'length', 'max'=>19),
			array('descripcion, modificado', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, album_video_id, proveedor_video_id, url_id, url_video, nombre, descripcion, duracion, creado, modificado, estado, destacado', 'safe', 'on'=>'search'),
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
			'albumVideo' => array(self::BELONGS_TO, 'AlbumVideo', 'album_video_id'),
			'proveedorVideo' => array(self::BELONGS_TO, 'ProveedorVideo', 'proveedor_video_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'album_video_id' => 'Album Video',
			'proveedor_video_id' => 'Proveedor Video',
			'url_id' => 'Url',
			'url_video' => 'Url Video',
			'nombre' => 'Nombre',
			'descripcion' => 'Descripcion',
			'duracion' => 'Duracion',
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
		$criteria->compare('album_video_id',$this->album_video_id,true);
		$criteria->compare('proveedor_video_id',$this->proveedor_video_id,true);
		$criteria->compare('url_id',$this->url_id,true);
		$criteria->compare('url_video',$this->url_video,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('duracion',$this->duracion,true);
		$criteria->compare('creado',$this->creado,true);
		$criteria->compare('modificado',$this->modificado,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('destacado',$this->destacado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
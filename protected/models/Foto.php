<?php

/**
 * This is the model class for table "foto".
 *
 * The followings are the available columns in table 'foto':
 * @property string $id
 * @property string $album_foto_id
 * @property string $src
 * @property string $thumb
 * @property string $nombre
 * @property string $descripcion
 * @property string $ancho
 * @property string $alto
 * @property string $creado
 * @property string $modificado
 * @property integer $estado
 * @property integer $destacado
 *
 * The followings are the available model relations:
 * @property AlbumFoto $albumFoto
 */
class Foto extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Foto the static model class
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
		return 'foto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('album_foto_id, url_id, src, thumb, nombre, ancho, alto, estado, destacado', 'required'),
			array('album_foto_id, url_id, estado, destacado', 'numerical', 'integerOnly'=>true),
			array('album_foto_id, ancho, alto', 'length', 'max'=>10),
			array('src, thumb', 'length', 'max'=>255),
			array('nombre', 'length', 'max'=>100),
			array('descripcion, creado, modificado', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, album_foto_id, url_id, src, thumb, nombre, descripcion, ancho, alto, creado, modificado, estado, destacado', 'safe', 'on'=>'search'),
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
			'albumFoto' => array(self::BELONGS_TO, 'AlbumFoto', 'album_foto_id'),
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
			'album_foto_id' => 'Álbum de fotos',
			'url_id' => 'Url',
			'src' => 'Src',
			'thumb' => 'Miniatura',
			'nombre' => 'Nombre',
			'descripcion' => 'Descripción',
			'ancho' => 'Ancho',
			'alto' => 'Alto',
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
		$criteria->compare('album_foto_id',$this->album_foto_id,true);
		$criteria->compare('url_id',$this->url_id,true);
		$criteria->compare('src',$this->src,true);
		$criteria->compare('thumb',$this->thumb,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('ancho',$this->ancho,true);
		$criteria->compare('alto',$this->alto,true);
		$criteria->compare('creado',$this->creado,true);
		$criteria->compare('modificado',$this->modificado,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('destacado',$this->destacado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
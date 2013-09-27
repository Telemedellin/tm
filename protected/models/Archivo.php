<?php

/**
 * This is the model class for table "archivo".
 *
 * The followings are the available columns in table 'archivo':
 * @property string $id
 * @property string $url_id
 * @property string $tipo_archivo_id
 * @property string $carpeta_id
 * @property string $nombre
 * @property string $archivo
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Carpeta $carpeta
 * @property TipoArchivo $tipoArchivo
 * @property Url $url
 */
class Archivo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Archivo the static model class
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
		return 'archivo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('url_id, tipo_archivo_id, carpeta_id, nombre, archivo, estado', 'required'),
			array('estado', 'numerical', 'integerOnly'=>true),
			array('url_id, tipo_archivo_id, carpeta_id', 'length', 'max'=>10),
			array('nombre, archivo', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, url_id, tipo_archivo_id, carpeta_id, nombre, archivo, estado', 'safe', 'on'=>'search'),
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
			'carpeta' => array(self::BELONGS_TO, 'Carpeta', 'carpeta_id'),
			'tipoArchivo' => array(self::BELONGS_TO, 'TipoArchivo', 'tipo_archivo_id'),
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
			'url_id' => 'Url',
			'tipo_archivo_id' => 'Tipo Archivo',
			'carpeta_id' => 'Carpeta',
			'nombre' => 'Nombre',
			'archivo' => 'Archivo',
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
		$criteria->compare('url_id',$this->url_id,true);
		$criteria->compare('tipo_archivo_id',$this->tipo_archivo_id,true);
		$criteria->compare('carpeta_id',$this->carpeta_id,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('archivo',$this->archivo,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
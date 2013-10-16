<?php

/**
 * This is the model class for table "red_social".
 *
 * The followings are the available columns in table 'red_social':
 * @property string $id
 * @property string $micrositio_id
 * @property string $tipo_red_social_id
 * @property string $usuario
 * @property string $nombre
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Micrositio $micrositio
 * @property TipoRedSocial $tipoRedSocial
 */
class RedSocial extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RedSocial the static model class
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
		return 'red_social';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('micrositio_id, tipo_red_social_id, usuario, estado', 'required'),
			array('estado', 'numerical', 'integerOnly'=>true),
			array('micrositio_id, tipo_red_social_id', 'length', 'max'=>10),
			array('usuario', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, micrositio_id, tipo_red_social_id, usuario, estado', 'safe', 'on'=>'search'),
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
			'micrositio' => array(self::BELONGS_TO, 'Micrositio', 'micrositio_id'),
			'tipoRedSocial' => array(self::BELONGS_TO, 'TipoRedSocial', 'tipo_red_social_id'),
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
			'tipo_red_social_id' => 'Tipo Red Social',
			'usuario' => 'Usuario',
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
		$criteria->compare('micrositio_id',$this->micrositio_id,true);
		$criteria->compare('tipo_red_social_id',$this->tipo_red_social_id,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
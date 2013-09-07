<?php

/**
 * This is the model class for table "fecha_especial".
 *
 * The followings are the available columns in table 'fecha_especial':
 * @property string $id
 * @property string $pg_especial_id
 * @property string $fecha
 * @property integer $hora_inicio
 * @property integer $hora_fin
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property PgEspecial $pgEspecial
 */
class FechaEspecial extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FechaEspecial the static model class
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
		return 'fecha_especial';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pg_especial_id, fecha, hora_inicio, hora_fin, estado', 'required'),
			array('hora_inicio, hora_fin, estado', 'numerical', 'integerOnly'=>true),
			array('pg_especial_id', 'length', 'max'=>10),
			array('fecha', 'length', 'max'=>19),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pg_especial_id, fecha, hora_inicio, hora_fin, estado', 'safe', 'on'=>'search'),
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
			'pgEspecial' => array(self::BELONGS_TO, 'PgEspecial', 'pg_especial_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pg_especial_id' => 'Pg Especial',
			'fecha' => 'Fecha',
			'hora_inicio' => 'Hora Inicio',
			'hora_fin' => 'Hora Fin',
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
		$criteria->compare('pg_especial_id',$this->pg_especial_id,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('hora_inicio',$this->hora_inicio);
		$criteria->compare('hora_fin',$this->hora_fin);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "horario".
 *
 * The followings are the available columns in table 'horario':
 * @property string $id
 * @property string $pg_programa_id
 * @property integer $dia_semana
 * @property integer $hora_inicio
 * @property integer $hora_fin
 * @property string $tipo_emision_id
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property TipoEmision $tipoEmision
 * @property PgPrograma $pgPrograma
 */
class Horario extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Horario the static model class
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
		return 'horario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pg_programa_id, dia_semana, hora_inicio, hora_fin, tipo_emision_id, estado', 'required'),
			array('dia_semana, hora_inicio, hora_fin, estado', 'numerical', 'integerOnly'=>true),
			array('pg_programa_id, tipo_emision_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pg_programa_id, dia_semana, hora_inicio, hora_fin, tipo_emision_id, estado', 'safe', 'on'=>'search'),
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
			'tipoEmision' => array(self::BELONGS_TO, 'TipoEmision', 'tipo_emision_id'),
			'pgPrograma' => array(self::BELONGS_TO, 'PgPrograma', 'pg_programa_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pg_programa_id' => 'Programa',
			'dia_semana' => 'Día de la semana',
			'hora_inicio' => 'Hora de inicio',
			'hora_fin' => 'Hora de terminación',
			'tipo_emision_id' => 'Tipo de emisión',
			'estado' => 'Publicado',
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
		$criteria->compare('pg_programa_id',$this->pg_programa_id,true);
		$criteria->compare('dia_semana',$this->dia_semana);
		$criteria->compare('hora_inicio',$this->hora_inicio);
		$criteria->compare('hora_fin',$this->hora_fin);
		$criteria->compare('tipo_emision_id',$this->tipo_emision_id,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "puntaje".
 *
 * The followings are the available columns in table 'puntaje':
 * @property integer $id
 * @property integer $usuario_id
 * @property integer $app_id
 * @property string $referencia
 * @property string $fecha
 * @property string $dispositivo
 * @property integer $puntos
 *
 * The followings are the available model relations:
 * @property Puntaje[] $puntajes
 */
class Puntaje extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Puntaje the static model class
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
		return 'puntaje';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario_id, app_id, referencia, fecha', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, usuario_id, app_id, referencia, fecha', 'safe', 'on'=>'search'),
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
			'App' => array(self::BELONGS_TO, 'App', 'app_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'usuario_id' => 'Usuario',
			'app_id' => 'App', 
			'referencia' => 'Referencia', 
			'fecha' => 'Fecha', 
			'dispositivo' => 'Dispositivo', 
			'puntos' => 'Puntos', 
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

		$criteria->compare('id',$this->id);
		$criteria->compare('usuario_id',$this->usuario_id,true);
		$criteria->compare('app_id',$this->app_id,true);
		$criteria->compare('referencia',$this->referencia,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('dispositivo',$this->dispositivo,true);
		$criteria->compare('puntos',$this->puntos,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}
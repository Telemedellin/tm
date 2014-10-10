<?php

/**
 * This is the model class for table "ronda_x_respuesta".
 *
 * The followings are the available columns in table 'ronda_x_respuesta':
 * @property integer $id
 * @property integer $ronda_id
 * @property integer $respuesta_id
 * @property integer $usuario_id
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Respuesta $respuesta
 * @property Ronda $ronda
 */
class RondaXRespuesta extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RondaXRespuesta the static model class
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
		return 'ronda_x_respuesta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ronda_id, respuesta_id, usuario_id', 'required'),
			array('ronda_id, respuesta_id, usuario_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ronda_id, respuesta_id, usuario_id', 'safe', 'on'=>'search'),
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
			'respuesta' => array(self::BELONGS_TO, 'Respuesta', 'respuesta_id'),
			'ronda' => array(self::BELONGS_TO, 'Ronda', 'ronda_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ronda_id' => 'Ronda',
			'respuesta_id' => 'Respuesta',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('ronda_id',$this->ronda_id);
		$criteria->compare('respuesta_id',$this->respuesta_id);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave()
	{
 
        if($this->isNewRecord)
        {
        	$this->fecha 		= date('Y-m-d H:i:s');
        }
        return parent::beforeSave();
	}
}
<?php

/**
 * This is the model class for table "micrositio_x_relacionado".
 *
 * The followings are the available columns in table 'micrositio_x_relacionado':
 * @property integer $id
 * @property integer $micrositio_id
 * @property integer $relacionado_id
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Micrositio $micrositio
 * @property Relacionado $relacionado
 */
class MicrositioXRelacionado extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MicrositioXRelacionado the static model class
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
		return 'micrositio_x_relacionado';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('micrositio_id, relacionado_id', 'required'),
			array('micrositio_id, relacionado_id, orden', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, micrositio_id, relacionado_id, creado', 'safe', 'on'=>'search'),
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
			'relacionado' => array(self::BELONGS_TO, 'Micrositio', 'relacionado_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'relacionado_id' => 'Relacionado',
			'micrositio_id' => 'Micrositio',
			'orden'	=> 'Orden', 
			'creado' => 'Creado', 
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
		$criteria->compare('relacionado_id',$this->relacionado_id);
		$criteria->compare('micrositio_id',$this->micrositio_id);
		$criteria->compare('orden',$this->orden);
		$criteria->compare('creado',$this->creado);
		$criteria->compare('estado',$this->estado);
		$criteria->order = 'orden ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave()
	{
        if($this->isNewRecord)
        {
        	$this->creado = date('Y-m-d H:i:s');
        	$this->estado = 1;
        }
        return parent::beforeSave();
	}
}
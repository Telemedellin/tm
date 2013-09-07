<?php

/**
 * This is the model class for table "pg_especial".
 *
 * The followings are the available columns in table 'pg_especial':
 * @property string $id
 * @property string $pagina_id
 * @property string $resena
 * @property string $lugar
 * @property string $presentadores
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property FechaEspecial[] $fechaEspecials
 * @property Pagina $pagina
 */
class PgEspecial extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PgEspecial the static model class
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
		return 'pg_especial';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pagina_id, resena, estado', 'required'),
			array('estado', 'numerical', 'integerOnly'=>true),
			array('pagina_id', 'length', 'max'=>10),
			array('lugar', 'length', 'max'=>45),
			array('presentadores', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pagina_id, resena, lugar, presentadores, estado', 'safe', 'on'=>'search'),
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
			'fechaEspecials' => array(self::HAS_MANY, 'FechaEspecial', 'pg_especial_id'),
			'pagina' => array(self::BELONGS_TO, 'Pagina', 'pagina_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pagina_id' => 'Pagina',
			'resena' => 'Resena',
			'lugar' => 'Lugar',
			'presentadores' => 'Presentadores',
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
		$criteria->compare('pagina_id',$this->pagina_id,true);
		$criteria->compare('resena',$this->resena,true);
		$criteria->compare('lugar',$this->lugar,true);
		$criteria->compare('presentadores',$this->presentadores,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
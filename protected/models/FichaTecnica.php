<?php

/**
 * This is the model class for table "ficha_tecnica".
 *
 * The followings are the available columns in table 'ficha_tecnica':
 * @property string $id
 * @property string $pg_documental_id
 * @property string $campo
 * @property string $valor
 * @property integer $orden
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property PgDocumental $pgDocumental
 */
class FichaTecnica extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FichaTecnica the static model class
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
		return 'ficha_tecnica';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pg_documental_id, campo, valor, estado', 'required'),
			array('orden, estado', 'numerical', 'integerOnly'=>true),
			array('pg_documental_id', 'length', 'max'=>10),
			array('campo', 'length', 'max'=>100),
			array('valor', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pg_documental_id, campo, valor, orden, estado', 'safe', 'on'=>'search'),
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
			'pgDocumental' => array(self::BELONGS_TO, 'PgDocumental', 'pg_documental_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pg_documental_id' => 'Página Documental',
			'campo' => 'Campo',
			'valor' => 'Valor',
			'orden' => 'Orden',
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
		$criteria->compare('pg_documental_id',$this->pg_documental_id,true);
		$criteria->compare('campo',$this->campo,true);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('orden',$this->orden);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
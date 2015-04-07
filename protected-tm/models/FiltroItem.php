<?php

/**
 * This is the model class for table "ficha_tecnica".
 *
 * The followings are the available columns in table 'ficha_tecnica':
 * @property string $id
 * @property string $pg_filtro_id
 * @property string $elemento
 * @property string $hijos
 * @property string $padre
 * @property integer $orden
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property PgDocumental $pgDocumental
 */
class FiltroItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FiltroItem the static model class
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
		return 'filtro_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pg_filtro_id, elemento, estado', 'required'),
			array('hijos, padre, orden, estado', 'numerical', 'integerOnly'=>true),
			array('pg_filtro_id', 'length', 'max'=>10),
			array('elemento', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pg_filtro_id, elemento, hijos, padre, orden, estado', 'safe', 'on'=>'search'),
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
			'pgFiltro' => array(self::BELONGS_TO, 'PgFiltro', 'pg_filtro_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pg_filtro_id' => 'Página Filtro',
			'elemento' => 'Elemento',
			'hijos' => 'Hijos',
			'padre' => 'Padre',
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
		$criteria->compare('pg_filtro_id',$this->pg_filtro_id,true);
		$criteria->compare('elemento',$this->elemento,true);
		$criteria->compare('hijos',$this->hijos,true);
		$criteria->compare('padre',$this->padre,true);
		$criteria->compare('orden',$this->orden);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
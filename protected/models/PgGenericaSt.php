<?php

/**
 * This is the model class for table "pg_generica_st".
 *
 * The followings are the available columns in table 'pg_generica_st':
 * @property string $id
 * @property string $titulo
 * @property string $texto
 * @property integer $estado
 */
class PgGenericaSt extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PgGenericaSt the static model class
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
		return 'pg_generica_st';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('texto', 'required'),
			array('estado', 'numerical', 'integerOnly'=>true),
			array('imagen, miniatura', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, texto, estado', 'safe', 'on'=>'search'),
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
			'pagina_id' => 'Página', 
			'texto' => 'Texto',
			'imagen' => 'Imagen de fondo',
			'miniatura' => 'Miniatura',
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
		$criteria->compare('texto',$this->texto,true);
		$criteria->compare('imagen',$this->imagen,true);
		$criteria->compare('miniatura',$this->miniatura,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php

/**
 * This is the model class for table "pg_documental".
 *
 * The followings are the available columns in table 'pg_documental':
 * @property string $id
 * @property string $pagina_id
 * @property string $titulo
 * @property integer $duracion
 * @property integer $anio
 * @property string $sinopsis
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property FichaTecnica[] $fichaTecnicas
 * @property Pagina $pagina
 */
class PgDocumental extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PgDocumental the static model class
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
		return 'pg_documental';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pagina_id, titulo, duracion, anio, sinopsis, estado', 'required'),
			array('duracion, anio, estado', 'numerical', 'integerOnly'=>true),
			array('pagina_id', 'length', 'max'=>10),
			array('titulo', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pagina_id, titulo, duracion, anio, sinopsis, estado', 'safe', 'on'=>'search'),
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
			'fichaTecnicas' => array(self::HAS_MANY, 'FichaTecnica', 'pg_documental_id'),
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
			'titulo' => 'Titulo',
			'duracion' => 'Duracion',
			'anio' => 'Anio',
			'sinopsis' => 'Sinopsis',
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
		$criteria->compare('titulo',$this->titulo,true);
		$criteria->compare('duracion',$this->duracion);
		$criteria->compare('anio',$this->anio);
		$criteria->compare('sinopsis',$this->sinopsis,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
<?php
/**
 * This is the model class for table "bloque".
 *
 * The followings are the available columns in table 'bloque':
 * @property string $id
 * @property string $pg_bloques_id
 * @property string $titulo
 * @property string $columnas
 * @property integer $orden
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property PgDocumental $pgDocumental
 */
class Bloque extends CActiveRecord
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
		return 'bloque';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pg_bloques_id, columnas, contenido, orden, estado', 'required'),
			array('columnas, orden, estado', 'numerical', 'integerOnly'=>true),
			array('pg_bloques_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pg_bloques_id, titulo, columnas, contenido, orden, estado', 'safe', 'on'=>'search'),
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
			'pgBloques' => array(self::BELONGS_TO, 'PgBloques', 'pg_bloques_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pg_bloques_id' => 'Página Bloques',
			'titulo' => 'Título',
			'columnas' => 'Columnas',
			'contenido' => 'Contenido',
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
		$criteria->compare('pg_bloques_id',$this->pg_bloques_id,true);
		$criteria->compare('titulo',$this->titulo,true);
		$criteria->compare('columnas',$this->columnas,true);
		$criteria->compare('contenido',$this->contenido,true);
		$criteria->compare('orden',$this->orden);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
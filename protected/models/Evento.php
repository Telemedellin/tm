<?php
/**
 * This is the model class for table "evento".
 *
 * The followings are the available columns in table 'evento':
 * @property string $id
 * @property string $pg_eventos_id
 * @property string $nombre
 * @property string $fecha
 * @property integer $hora
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property PgDocumental $pgDocumental
 */
class Evento extends CActiveRecord
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
		return 'evento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pg_eventos_id, nombre, fecha, hora, estado', 'required'),
			array('fecha, hora, estado', 'numerical', 'integerOnly'=>true),
			array('pg_eventos_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pg_eventos_id, nombre, fecha, hora, estado', 'safe', 'on'=>'search'),
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
			'pgEventos' => array(self::BELONGS_TO, 'PgEventos', 'pg_eventos_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pg_eventos_id' => 'Página Eventos',
			'nombre' => 'Nombre',
			'fecha' => 'Fecha',
			'hora' => 'Hora',
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
		$criteria->compare('pg_eventos_id',$this->pg_eventos_id,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('hora',$this->hora);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
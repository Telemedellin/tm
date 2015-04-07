<?php

/**
 * This is the model class for table "tipo_campo".
 *
 * The followings are the available columns in table 'tipo_campo':
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $etiqueta
 * @property string $tipo
 * @property integer $autocierre
 * @property string $parametros
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Campo $campo
 */
class TipoCampo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TipoEmision the static model class
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
		return 'tipo_campo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, estado', 'required'),
			array('estado', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, descripcion, etiqueta, tipo, autocierre, parametros, estado', 'safe', 'on'=>'search'),
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
			'campo' => array(self::HAS_MANY, 'Campo', 'tipo_campo_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'descripcion' => 'Descripción', 
			'etiqueta' => 'Etiqueta', 
			'tipo' => 'Tipo', 
			'autocierre' => 'Autocierre', 
			'parametros' => 'Parámetros', 
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion', $this->descripcion, true);
		$criteria->compare('etiqueta', $this->etiqueta, true);
		$criteria->compare('tipo', $this->tipo, true);
		$criteria->compare('autocierre', $this->autocierre, true);
		$criteria->compare('parametros', $this->parametros, true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
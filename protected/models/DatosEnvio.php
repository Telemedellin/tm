<?php

/**
 * This is the model class for table "datos_envio".
 *
 * The followings are the available columns in table 'datos_envio':
 * @property integer $id
 * @property integer $envio_formulario_id
 * @property string $campo_nombre
 * @property string $valor
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property EnvioFormulario $envio_formulario 
 * @property Campo $campo_nombre
 */
class DatosEnvio extends CActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PgArticuloFormulario the static model class
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
		return 'datos_envio';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('envio_formulario_id, campo_nombre, valor', 'required'),
			array('envio_formulario_id, estado', 'numerical', 'integerOnly'=>true),
			array('envio_formulario_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, envio_formulario_id, campo_nombre, valor, estado', 'safe', 'on'=>'search'),
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
			'envioFormulario' => array(self::BELONGS_TO, 'EnvioFormulario', 'envio_formulario_id'),
			'campo' => array(self::BELONGS_TO, 'Campo', 'campo_nombre'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'envio_formulario_id' => 'Envio Formulario',
			'campo_nombre' => 'Campo', 
			'valor' => 'Valor', 
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
		$criteria->compare('envio_formulario_id',$this->envio_formulario_id,true);
 		$criteria->compare('campo_nombre', $this->campo_nombre, true);
 		$criteria->compare('valor', $this->valor, true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave()
	{
		
		$this->estado = 1;
        
	    return parent::beforeSave();
	}

}
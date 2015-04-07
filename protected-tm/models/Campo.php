<?php

/**
 * This is the model class for table "campo".
 *
 * The followings are the available columns in table 'campo':
 * @property integer $id
 * @property integer $pg_formulario_id
 * @property integer $tipo_campo_id
 * @property string $nombre
 * @property string $etiqueta
 * @property integer $requerido
 * @property string $css_id
 * @property string $ayuda
 * @property string $parametros
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property PgFormulario $pgFormulario
 * @property TipoCampo $tipo_campo
 */
class Campo extends CActiveRecord
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
		return 'campo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pg_formulario_id, estado', 'required'),
			array('pg_formulario_id, tipo_campo_id, estado', 'numerical', 'integerOnly'=>true),
			array('pg_formulario_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pg_formulario_id, tipo_campo_id, nombre, etiqueta, requerido, css_id, ayuda, parametros, estado', 'safe', 'on'=>'search'),
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
			'pgFormulario' => array(self::BELONGS_TO, 'PgFormulario', 'pg_formulario_id'),
			'tipo_campo' => array(self::BELONGS_TO, 'TipoCampo', 'tipo_campo_id'),
			'datosFormulario' => array(self::HAS_MANY, 'DatosEnvio', 'campo_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pg_formulario_id' => 'Página Formulario',
			'tipo_campo_id' => 'Tipo de campo', 
			'nombre' => 'Nombre', 
			'etiqueta' => 'Etiqueta', 
			'requerido' => 'Requerido', 
			'css_id' => 'ID CSS', 
			'ayuda' => 'Ayuda', 
			'parametros' => 'Parametros', 
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
		$criteria->compare('pg_formulario_id',$this->pg_formulario_id,true);
		$criteria->compare('tipo_campo_id', $this->tipo_campo_id, true);
		$criteria->compare('nombre', $this->nombre, true);
		$criteria->compare('etiqueta', $this->etiqueta, true);
		$criteria->compare('requerido', $this->requerido, true);
		$criteria->compare('css_id', $this->css_id, true);
		$criteria->compare('ayuda', $this->ayuda, true);
		$criteria->compare('parametros', $this->parametros, true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
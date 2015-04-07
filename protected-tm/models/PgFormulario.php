<?php

/**
 * This is the model class for table "pg_formulario".
 *
 * The followings are the available columns in table 'pg_formulario':
 * @property integer $id
 * @property integer $pagina_id
 * @property string $correo
 * @property string $fecha_apertura
 * @property string $fecha_cierre
 * @property string $mensaje_apertura
 * @property string $mensaje_cierre
 * @property integer $limite_envios
 * @property string $mensaje_limite
 * @property string $mensaje_envio
 * @property integer $limite_por_usuario
 * @property string $custom_css
 * @property string $custom_js
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Pagina $pagina
 * @property Campo $campo
 * @property EnvioFormulario $envio_formulario
 */
class PgFormulario extends CActiveRecord
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
		return 'pg_formulario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pagina_id, estado', 'required'),
			array('pagina_id, limite_envios, limite_por_usuario, estado', 'numerical', 'integerOnly'=>true),
			array('pagina_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pagina_id, correo, fecha_apertura, fecha_cierre, mensaje_apertura, mensaje_cierre, limite_envios, mensaje_limite, mensaje_envio, limite_por_usuario, custom_css, custom_js, estado', 'safe', 'on'=>'search'),
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
			'campo' => array(self::HAS_MANY, 'Campo', 'pg_formulario_id'),
			'envioFormulario' => array(self::HAS_MANY, 'EnvioFormulario', 'pg_formulario_id'),
			'enviosCount'=>array(self::STAT, 'EnvioFormulario', 'pg_formulario_id'),
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
			'correo' => 'Correo', 
			'fecha_apertura' => 'Fecha de apertura', 
			'fecha_cierre' => 'Fecha de cierre', 
			'mensaje_apertura' => 'Mensaje de apertura', 
			'mensaje_cierre' => 'Mensaje de cierre', 
			'limite_envios' => 'Límite de envíos', 
			'mensaje_limite' => 'Mensaje límite', 
			'mensaje_envio' => 'Mensaje envío', 
			'limite_por_usuario' => 'Límite por usuario', 
			'custom_css' => 'CSS Personalizado', 
			'custom_js' => 'JavaScript Personalizado', 
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
		$criteria->compare('correo', $this->correo, true);
		$criteria->compare('fecha_apertura', $this->fecha_apertura, true);
		$criteria->compare('fecha_cierre', $this->fecha_cierre, true);
		$criteria->compare('mensaje_apertura', $this->mensaje_apertura, true);
		$criteria->compare('mensaje_cierre', $this->mensaje_cierre, true);
		$criteria->compare('limite_envios', $this->limite_envios, true);
		$criteria->compare('mensaje_limite', $this->mensaje_limite, true);
		$criteria->compare('mensaje_envio', $this->mensaje_envio, true);
		$criteria->compare('limite_por_usuario', $this->limite_por_usuario, true);
		$criteria->compare('custom_css', $this->custom_css, true);
		$criteria->compare('custom_js', $this->custom_js, true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function datos_por_usuario( $usuario_id )
	{
		return $this->datos_formulario->countByAttributes( array('usuario_id' => $usuario_id) );
	}

}
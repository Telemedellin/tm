<?php

/**
 * This is the model class for table "envio_formulario".
 *
 * The followings are the available columns in table 'envio_formulario':
 * @property integer $id
 * @property integer $pg_formulario_id
 * @property integer $usuario_id
 * @property string $fecha_envio
 * @property string $ip
 * @property string $enviado_a
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property PgFormulario $pg_formulario 
 */
class EnvioFormulario extends CActiveRecord
{

	private $transaccion;

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
		return 'envio_formulario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pg_formulario_id', 'required'),
			array('pg_formulario_id, usuario_id, estado', 'numerical', 'integerOnly'=>true),
			array('pg_formulario_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pg_formulario_id, usuario_id, fecha_envio, ip, enviado_a, estado', 'safe', 'on'=>'search'),
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
			'datosEnvio' => array(self::HAS_MANY, 'DatosEnvio', 'envio_formulario_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pg_formulario_id' => 'Pagina',
			'usuario_id' => 'Usuario', 
			'fecha_envio' => 'Fecha de envío', 
			'ip' => 'IP', 
			'enviado_a' => 'Enviado a', 
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
		$criteria->compare('pg_formulario_id',$this->pg_formulario_id,true);
 		$criteria->compare('usuario_id', $this->usuario_id, true);
 		$criteria->compare('fecha_envio', $this->fecha_envio, true);
 		$criteria->compare('ip', $this->ip, true);
 		$criteria->compare('enviado_a', $this->enviado_a, true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function guardar_envio( $pg_formulario_id, $model, $enviado_a = false )
	{
		$this->transaccion = $this->dbConnection->getCurrentTransaction();
		if( is_null($this->transaccion) )
			$this->transaccion = $this->dbConnection->beginTransaction();

		try
		{
			$this->pg_formulario_id = $pg_formulario_id;
			
			if( $enviado_a )
				$this->enviado_a = $enviado_a;

			if( $this->save() )
			{
				foreach( $model as $k => $v)
				{
					$de = new DatosEnvio;
					$de->envio_formulario_id = $this->getPrimaryKey();
					$de->campo_nombre = $k;
					if( is_array($v) )
						$de->valor = serialize($v);
					else
						$de->valor = $v;
					if( !$de->save() )
					{
						throw new Exception("No guardó de", 1);
					}
				}
				$this->transaccion->commit();
				return true;
			}else
			{
				throw new Exception("No guardó this", 1);
			}
			
		}//try
		catch(Exception $e)
		{
		   $this->transaccion->rollback();
		   Yii::log(
			PHP_EOL . '<--->'				.
			PHP_EOL . $e .
			CLogger::LEVEL_INFO
		);
		   return false;
		}

	}

	protected function beforeSave()
	{
		if( Yii::app()->user->isGuest ) return false;

		$this->usuario_id 	= Yii::app()->user->getState('usuario_id');
		$this->fecha_envio	= date('Y-m-d H:i:s');
		$this->ip			= Yii::app()->request->userHostAddress;
		$this->estado 		= 1;
        
	    return parent::beforeSave();
	}

}
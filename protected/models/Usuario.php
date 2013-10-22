<?php

/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property integer $id
 * @property string $correo
 * @property string $password
 * @property string $llave
 * @property integer $estado
 * @property integer $es_admin
 *
 * The followings are the available model relations:
 * @property Jugador[] $jugadors
 */
class Usuario extends CActiveRecord
{
	private $sal = '/T0D0534c14r4*';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Usuario the static model class
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
		return 'usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, correo, password', 'required'),
			array('correo', 'length', 'max'=>100),
			array('correo', 'email'),
			array('correo', 'unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, correo, password, llave, creado, estado, es_admin', 'safe', 'on'=>'search'),
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
			'correo' => 'Correo',
			'password' => 'Contraseña',
			'llave' => 'Llave',
			'creado' => 'Creado',
			'estado' => 'Estado',
			'es_admin' => 'Es Admin',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('correo',$this->correo,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('llave',$this->llave,true);
		$criteria->compare('creado',$this->creado,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('es_admin',$this->es_admin);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function validatePassword($password)
	{
		return md5($password . $this->sal) === $this->password;
	}

	public function verificarLlave($llave)
	{
		$existe = $this->find(
			array(
				'select' 	=> 'id',
				'condition' => 'llave=:llave',
				'params'	=> array(':llave' => $llave),
			)
		);
		if($existe)
		{
			$existe->updateByPk($existe->id, array('llave' => '', 'estado' => 1));
			return $existe;
		}
		else
			return false;
		

	}

	public function validarToken($llave)
	{
		$existe = $this->find(
			array(
				'select' 	=> 'id',
				'condition' => 'llave=:llave',
				'params'	=> array(':llave' => $llave),
			)
		);
		if($existe)
		{
			$existe->findByPk($existe->id/*, array('llave_activacion' => '', 'estado' => 1)*/);
			return $existe;
		}
		else
			return false;
		

	}

	public function actualizarClave($usuario_id)
	{
		$this->password = md5($this->password . $this->sal);
		$this->updateByPk( $usuario_id, array('password' => $this->password, 'llave' => '', 'estado' => 1) );
		return true;
	}

	protected function beforeSave()
	{
		if (!empty($this->password))
        	$this->password = md5($this->password . $this->sal);
        
        if($this->isNewRecord)
        {
        	$this->estado 			= 1;
        	$this->llave = md5( 't3l3m3d3lL1n-hd' . (rand() + time()) . $this->sal );
        	$this->es_admin 		= 0;	
        }
        
    	return true;
	}
}
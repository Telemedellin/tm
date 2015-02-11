<?php

/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property integer $id
 *
 * The followings are the available model relations:
 * @property Jugador[] $jugadors
 */
class Usuario extends CActiveRecord
{

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
			//array('nombres, correo, password', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nombres, apellidos, sexo, tipo_documento, documento, nacimiento, nivel_educacion_id, ocupacion_id, telefono_fijo, celular, pais_id, region_id, ciudad_id, barrio_id, cableoperador_id', 'safe'/*, 'on'=>'search'/**/),
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
			'crugeuserid' => array(self::BELONGS_TO, 'CrugeStoredUser', 'cruge_user_id'),
			'nivelEducacion' => array(self::BELONGS_TO, 'NivelEducacion', 'nivelEducacion_id'),
			'ocupacion' => array(self::BELONGS_TO, 'Ocupacion', 'ocupacion_id'),
			'pais' => array(self::BELONGS_TO, 'Pais', 'pais_id'),
			'region' => array(self::BELONGS_TO, 'Region', 'region_id'),
			'ciudad' => array(self::BELONGS_TO, 'Ciudad', 'ciudad_id'),
			'barrio' => array(self::BELONGS_TO, 'Barrio', 'barrio_id'),
			'cableoperador' => array(self::BELONGS_TO, 'Cableoperador', 'cableoperador_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombres' => 'Nombres',
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
		$criteria->compare('nombres',$this->nombres,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function registrar_usuario_cruge( $correo, $gen_key = true, $contrasena = null )
	{
		
		$usuario_cruge = Yii::app()->user->um->createBlankUser();
		$usuario_cruge->email = $correo;

		if( Yii::app()->user->um->loadUser($usuario_cruge->email) != null ) 
		{
			if( $usuario_cruge->password != NULL && $usuario_cruge->state != 0 )
				return $usuario_cruge;
		}
		else
		{
			$mail_validator = new CEmailValidator;
			if( !$mail_validator->validateValue($correo) ){
			   return false;
			}
			
			if( $gen_key )
	        	$usuario_cruge->authkey = md5(uniqid(time().rand(), true));
	        $usuario_cruge->username = Yii::app()->user->um->generateNewUsername($correo);
			
			if( $contrasena != null )
				Yii::app()->user->um->changePassword($usuario_cruge, $contrasena);
			
			

			if( Yii::app()->user->um->save($usuario_cruge) )
				return $usuario_cruge;
			else
			{
				Yii::log(
	            	PHP_EOL . '<--->'.PHP_EOL .$e->getMessage().PHP_EOL, 
					'warning'
				);
				return false;
			}
		}

	}

	public function guardar_datos_usuario( $usuario_cruge, $datos_usuario )
	{
		if( $usuario_cruge == null || $usuario_cruge == false) return false;
		$u = Usuario::model()->findByAttributes( array('cruge_user_id' => $usuario_cruge->iduser) );
		if( $u ) return $u;
		try
		{
			if( isset($datos_usuario->anio) )
			{
				$nacimiento = $datos_usuario->anio . '-' . $datos_usuario->mes . '-' . $datos_usuario->dia;
			}
			if( isset($datos_usuario->nacimiento) )
			{
				//$nacimiento = new DateTime($datos_usuario->nacimiento);
				//$nacimiento = date_format($nacimiento, 'Y-m-d'); 
				Yii::log('Nacimiento: ' . $datos_usuario->nacimiento, 'info');
				$nacimiento = date('Y-m-d', strtotime($datos_usuario->nacimiento));
				Yii::log('Nacimiento Convertido: ' . $nacimiento, 'info');
			}
			
			if( strlen($datos_usuario->sexo) > 1)
				$datos_usuario->sexo = ($datos_usuario->sexo == 'female')?'F':'M';

	        $this->cruge_user_id     = $usuario_cruge->primaryKey;
	        if( isset($datos_usuario->nombres) )
	        	$this->nombres           = $datos_usuario->nombres;
	        if( isset($datos_usuario->apellidos) )
	        	$this->apellidos         = $datos_usuario->apellidos;
	        if( isset($datos_usuario->sexo) )
	        	$this->sexo              = $datos_usuario->sexo;
	        if( isset($datos_usuario->tipo_documento) )
	        	$this->tipo_documento    = $datos_usuario->tipo_documento;
	        if( isset($datos_usuario->documento) )
	        	$this->documento         = $datos_usuario->documento;
	        if( isset($datos_usuario->anio) )
	        	$this->nacimiento        = $nacimiento;
	        if( isset($datos_usuario->nivel_educacion_id) ) 
	        	$this->nivel_educacion_id= $datos_usuario->nivel_educacion_id;
	        if( isset($datos_usuario->ocupacion_id) )
	        	$this->ocupacion_id      = $datos_usuario->ocupacion_id;
	        if( isset($datos_usuario->telefono_fijo) )
	        	$this->telefono_fijo     = $datos_usuario->telefono_fijo;
	        if( isset($datos_usuario->celular) )
	        	$this->celular           = $datos_usuario->celular;
	        if( isset($datos_usuario->pais_id) )
	        	$this->pais_id           = $datos_usuario->pais_id ;
	        if( isset($datos_usuario->region_id) )
	        	$this->region_id           = $datos_usuario->region_id ;
	        if( isset($datos_usuario->ciudad_id) )
	        	$this->ciudad_id         = $datos_usuario->ciudad_id;
	        if( isset($datos_usuario->barrio_id) )
	        	$this->barrio_id         = $datos_usuario->barrio_id;
	        if( isset($datos->cableoperador_id) )
	        	$this->cableoperador_id  = $datos_usuario->cableoperador_id;
	        
	        if( $this->save(false) )
	        {
	            $datosMC = array(
	            			'FNAME' => $datos_usuario->nombres,
	            			'LNAME' => $datos_usuario->apellidos
	            		);
	            if( Yii::app()->mailchimp->emailExists($usuario_cruge->email) )
	            {
	            	Yii::app()->mailchimp->listUpdateMember($usuario_cruge->email, $datosMC);
	            	Yii::log('mailchimp->listUpdateMember', 'info');
	            }else
	            {
	            	Yii::app()->mailchimp->listSubscribe($usuario_cruge->email, $datosMC, false);
	            	Yii::log('mailchimp->listSubscribe', 'info');
	            }
	            return $this->getPrimaryKey();
	        }else
	        {
	        	throw new Exception("El usuario {$usuario_cruge->email} no se pudo almacenar totalmente");
	        }
	    }
	    catch(Exception $e)
        {
            Yii::log(
            	PHP_EOL . '<--->'.PHP_EOL .$e->getMessage().PHP_EOL, 
				'warning'
			);
			return false;
        }
	}

}
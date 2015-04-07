<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $correo;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('correo, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'correo'	=> 'Correo',
			'password'	=> 'Contraseña',
			'rememberMe'=> 'Recordarme',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity = new UserIdentity($this->correo,$this->password);
			if(!$this->_identity->authenticate()){
				if($this->_identity->errorCode===UserIdentity::ERROR_STATUS)
		        {
		            $this->addError('correo','La cuenta aún no a sido activada');
		        }
		        else
		        {
		        	$this->addError('password','El correo o la contraseña no están bien');
		        }
			}
				
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity = new UserIdentity($this->correo,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode === UserIdentity::ERROR_NONE)
		{
			$duration=($this->rememberMe) ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity, $duration);
			Yii::app()->user->setState('id', $this->_identity->getId());
			Yii::app()->user->setState('correo', $this->_identity->getCorreo());
			Yii::app()->user->setState('es_admin', $this->_identity->getEsAdmin());
			return true;
		}
		else
			return false;
	}
}
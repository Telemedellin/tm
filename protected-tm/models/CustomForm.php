<?php

/**
 * CustomForm class.
 * CustomForm is the data structure for keeping
 * custom form data. 
 */
class CustomForm extends CFormModel
{
	protected $_fields = array();
    protected $_rules = array();

	public function __construct($fields)
    {
        foreach ($fields as $field => $rules) {
            $this->_fields[$field] = null;
            $this->_rules[$field] = $rules;
        }

        parent::__construct();
    }

    public function __get($attribute)
    {

        if (in_array($attribute, array_keys($this->_fields))) {
            return $this->_fields[$attribute];
        } else {
            return parent::__get($attribute);
        }
    }

    public function __set($attribute, $value)
    {
        if (in_array($attribute, array_keys($this->_fields))) {
            return $this->_fields[$attribute] = $value;
        } else {
            return parent::__set($attribute, $value);
        }
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        $tmp_reglas = array();
        //print_r($this->_rules);//exit();
        foreach( $this->_rules as $campo => $reglas )
        {
            //print_r($campo);
            //print_r($reglas);
            if( is_array($reglas) )
                foreach( $reglas as $regla => $valor )
                {
                    $tmp_reglas[$regla][$campo] = $valor;
                }
            
        } //foreach( $this->_rules

        //print_r( $tmp_reglas );//exit();
        //echo PHP_EOL;

        $dreglas = $this->build_reglas($tmp_reglas);

        
        
        /*$allFields = implode(', ', array_keys($this->_fields));
        $dreglas[] = array($allFields, 'safe');/**/
        $dreglas[] = $this->concat_reglas('safe', $this->_fields);

        //print_r( $dreglas ); exit();

        /*
        array('correo, nombres, apellidos', 'required'),
        array('contrasena, repetir_contrasena', 'length', 'min'=>7, 'max'=>40),
        array('correo', 'email'),
        array('celular, ciudad_id, barrio_id, cableoperador_id', 'numerical', 'integerOnly'=>true),
        array('terminos', 'boolean'), 
        array('region_id, ciudad_id, barrio_id, cableoperador_id, verifyCode, terminos', 'safe'),
        /**/
        
        return $dreglas;
    }

    public function getAttributes()
    {
        return $this->_fields;
    }

    public function setAttributes($attributes)
    {
        $this->_fields = $attributes;
    }

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			
		);
	}

    private function build_reglas( $tmp_reglas )
    {
        foreach ($tmp_reglas as $regla => $campos) 
        {
            if( $regla == 'required' )
                $dreglas[] = $this->concat_reglas($regla, $campos);
            else
                foreach( $campos as $campo => $valor )
                {
                    $fregla = array( $campo, $regla );
                    if( is_array($valor) )
                    {
                        foreach( $valor as $k => $v)
                            $fregla[$k] = $v;
                    }
                    
                    $dreglas[] = $fregla;
                }
        }
        return $dreglas;
    }

    private function concat_reglas($regla, $campos)
    {
        $campos_string = implode(", ", array_keys($campos));
        return array( $campos_string, $regla );
    }
}
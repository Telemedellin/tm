<?php

/**
 * This is the model class for table "pregunta".
 *
 * The followings are the available columns in table 'pregunta':
 * @property integer $id
 * @property string $pregunta
 *
 * The followings are the available model relations:
 * @property PreguntaXRonda[] $preguntaXRondas
 * @property Respuesta[] $respuestas
 */
class Pregunta extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pregunta the static model class
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
		return 'pregunta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pregunta', 'required'),
			array('pregunta', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pregunta', 'safe', 'on'=>'search'),
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
			'RondaXPreguntas' => array(self::HAS_MANY, 'RondaXPregunta', 'pregunta_id'),
			'respuestas' => array(self::HAS_MANY, 'Respuesta', 'pregunta_id', 'select' => 'id, respuesta'),
			'respuestas_f' => array(self::HAS_MANY, 'Respuesta', 'pregunta_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pregunta' => 'Pregunta',
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
		$criteria->compare('pregunta',$this->pregunta,true);
		$criteria->with = array('respuestas');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>25,
			),
		));
	}

	public function obtener_pregunta($ronda_id, $pregunta_id = 0)
	{
		$rxp = new RondaXPregunta;
		$rxpn = $rxp::tableName();
		
		$c = new CDbCriteria;
		$c->join =  'JOIN ' . $rxpn . ' ON ' . $rxpn . '.pregunta_id = t.id';
		$c->addCondition($rxpn . '.ronda_id = :ronda_id');
		$params[':ronda_id'] = $ronda_id;

		if( $pregunta_id )
		{
			$c->addCondition($rxpn . '.pregunta_id = :pregunta_id');
			$params[':pregunta_id'] = $pregunta_id;
		}else
		{
			$max 		= $rxp->count('ronda_id='.$ronda_id);
			$c->offset 	= rand(0, $max-1);
		}

		$c->limit 		= 1;
		$c->params 		= $params;

		$pregunta = $this->findAll( $c );
		if(isset($pregunta[0]))
			 $pregunta = $pregunta[0];	

		if( $this->verificar_respuestas( $ronda_id, $pregunta ) )
			$pregunta = $this->obtener_pregunta( $ronda_id );

		return $pregunta;

	}

	protected function verificar_respuestas( $ronda_id, $pregunta )
	{
		$usuario = Usuario::model()->findByAttributes( array('cruge_user_id' => Yii::app()->user->id) );
		foreach($pregunta->respuestas as $r)
		{
			$rxr = RondaXRespuesta::model()->findByAttributes( 
						array('respuesta_id' => $r->id),
						'usuario_id = :usuario_id AND ronda_id = :ronda_id',
						array(':usuario_id' => $usuario->id, ':ronda_id' => $ronda_id) 
					);
			if( $rxr ) return true;
		}
			
		return false;
	}

}
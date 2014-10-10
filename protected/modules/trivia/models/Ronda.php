<?php

/**
 * This is the model class for table "ronda".
 *
 * The followings are the available columns in table 'ronda':
 * @property integer $id
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property integer $puntos
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property RondaXPregunta[] $rondaXPreguntas
 * @property RondaXPregunta[] $rondaXPreguntas
 * @property Usuario $usuario
 */
class Ronda extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ronda the static model class
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
		return 'ronda';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('puntos, estado', 'numerical', 'integerOnly'=>true),
			array('fecha_inicio, fecha_fin', 'safe'), 
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fecha_inicio, fecha_fin, puntos, estado', 'safe', 'on'=>'search'),
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
			'rondaXPreguntas' => array(self::HAS_MANY, 'RondaXPregunta', 'ronda_id'),
			'rondaXRespuestas' => array(self::HAS_MANY, 'RondaXRespuesta', 'ronda_id'),
			'usuario' => array(self::BELONGS_TO, 'Usuario', 'usuario_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fecha_inicio' => 'Fecha inicio',
			'fecha_fin' => 'Fecha final',
			'puntos' => 'Puntos',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('fecha_inicio',$this->fecha_inicio);
		$criteria->compare('fecha_fin',$this->fecha_fin);
		$criteria->compare('puntos',$this->puntos,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
	            'defaultOrder'=>'t.estado DESC, t.fecha_inicio DESC',
        	),
			'pagination'=>array(
				'pageSize'=>25,
			),
		));
	}

	public function getRondaActual()
	{
		//Definir qué pasa cuando hay varias rondas activas
		return $this->find( 'DATE(fecha_inicio) < DATE(NOW()) AND DATE(fecha_fin) > DATE(NOW())' );

		//$a = new CDbCriteria;
		//$a->addCondition('DATE(fecha)=DATE(NOW())');
		//return $this->findAll($a);

	}

	/*public function obtener_estadisticas($usuario_id = 0)
	{
		//Número total de rondas
		$numero_rondas = $this->obtener_numero_rondas($usuario_id);
		
		//Total preguntas
		$preguntas_total = $this->obtener_total($usuario_id, 'preguntas');

		//Puntos ultima ronda
		$puntos_ultima = $this->obtener_ultima($usuario_id, 'puntos');

		//Preguntas última ronda
		$preguntas_ultima = $this->obtener_ultima($usuario_id, 'preguntas');

		//Fecha última ronda
		$fecha_ultima = date( 'd-m-Y', strtotime( $this->obtener_ultima($usuario_id, 'fecha') ) );

		$estadisticas = array(	'rondas' 			=> $numero_rondas,
								'preguntas' 		=> $preguntas_total,
								'puntos_ultima' 	=> $puntos_ultima,
								'preguntas_ultima' 	=> $preguntas_ultima,
								'fecha_ultima' 		=> $fecha_ultima,
							);

		return $estadisticas;
	}//obtener_estadisticas

	protected function obtener_numero_rondas($usuario_id)
	{
		$rondas = $this->findAll('usuario_id = ' . $usuario_id);
		return count($rondas);
	}

	protected function obtener_total($usuario_id, $campo)
	{
		$c = new CDbCriteria;
		$c->select = 'Sum('.$campo.') AS '.$campo.', usuario_id';
		$c->group 	= 'usuario_id';
		$c->addCondition('usuario_id = ' . $usuario_id);
		$total = $this->find($c);
		return $total->$campo;
	}
	protected function obtener_ultima($usuario_id, $campo = null)
	{
		$c = new CDbCriteria;
		if($campo != null)
			$c->select = $campo.', usuario_id';
		$c->addCondition('usuario_id = ' . $usuario_id);
		$c->order = 'id DESC';
		$c->limit = 1;
		$ultima = $this->find($c);
		if($campo != null)
			return $ultima->$campo;
		else
			return $ultima;
	}/**/
}
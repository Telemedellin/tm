<?php

/**
 * This is the model class for table "programacion".
 *
 * The followings are the available columns in table 'programacion':
 * @property string $id
 * @property string $micrositio_id
 * @property string $hora_inicio
 * @property string $hora_fin
 * @property integer $tipo_emision_id
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Micrositio $micrositio
 */
class Programacion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Programacion the static model class
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
		return 'programacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('micrositio_id, hora_inicio, hora_fin, tipo_emision_id, estado', 'required'),
			array('tipo_emision_id, estado', 'numerical', 'integerOnly'=>true),
			array('micrositio_id', 'length', 'max'=>10),
			array('hora_inicio, hora_fin', 'length', 'max'=>19),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, micrositio_id, hora_inicio, hora_fin, tipo_emision_id, estado', 'safe', 'on'=>'search'),
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
			'micrositio' => array(self::BELONGS_TO, 'Micrositio', 'micrositio_id'),
			'tipoEmision' => array(self::BELONGS_TO, 'TipoEmision', 'tipo_emision_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'micrositio_id' => 'Micrositio',
			'hora_inicio' => 'Hora de inicio',
			'hora_fin' => 'Hora de terminación',
			'tipo_emision_id' => 'Tipo de emisión',
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
		$criteria->compare('micrositio_id',$this->micrositio_id,true);
		$criteria->compare('hora_inicio',$this->hora_inicio,true);
		$criteria->compare('hora_fin',$this->hora_fin,true);
		$criteria->compare('tipo_emision_id',$this->tipo_emision_id,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getDay( $timestamp )
	{
		if( !$timestamp ) $timestamp = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

		$c = new CDbCriteria;
		$c->addCondition('hora_inicio > ' . $timestamp);
		$c->addCondition(' hora_inicio < ' . ($timestamp + 86400));
		$c->addCondition(' t.estado <> 0' );
		$c->order = 'hora_inicio ASC';
		return $this->with('micrositio')->findAll( $c );
	}

	public function getCurrent()
	{
		$c = new CDbCriteria;
		$c->addCondition('hora_inicio < ' . time() );
		$c->addCondition(' hora_fin > ' . time() );
		$c->addCondition(' t.estado <> 0' );
		$c->order = 'hora_inicio ASC';
		$c->select = '*';
		$c->join = ' JOIN micrositio ON micrositio.id = t.micrositio_id';
		$c->join .= ' JOIN seccion ON seccion.id = micrositio.seccion_id';

		return $this->find( $c );
	}

	public function getNext()
	{
		$currentEndTime = time();

		$c = new CDbCriteria;
		$c->join = 'JOIN micrositio ON micrositio.id = t.micrositio_id';
		$c->join .= ' JOIN url ON micrositio.url_id = url.id';
		$c->addCondition('hora_inicio >= ' . $currentEndTime );
		$c->addCondition(' t.estado <> 0' );
		$c->order = 'hora_inicio ASC';

		return $this->find( $c );
	}

	/*protected function afterFind()
	{
	    $this->hora_inicio = date('Y-m-d H:i:s', $this->hora_inicio);
	    $this->hora_fin = date('Y-m-d H:i:s', $this->hora_fin);

	    return parent::afterFind();
	}*/

	protected function beforeSave()
	{
		date_default_timezone_set('America/Bogota');
		setlocale(LC_ALL, 'es_ES.UTF-8');
	    if(parent::beforeSave())
	    {
	        /*if($this->isNewRecord)
	        {
	        	$this->hora_inicio  = strtotime($this->hora_inicio);
	        	$this->hora_fin  = strtotime($this->hora_fin);
	        }
	        else
	        {
	            if($this->hora_inicio) $this->hora_inicio  = strtotime($this->hora_inicio);
	        	if($this->hora_fin) $this->hora_fin  = strtotime($this->hora_fin);
	        }*/
	        return true;
	    }
	    else
	        return false;
	}
}
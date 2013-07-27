<?php

/**
 * This is the model class for table "url".
 *
 * The followings are the available columns in table 'url':
 * @property string $id
 * @property string $slug
 * @property integer $tipo
 * @property string $creado
 * @property string $modificado
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Micrositio[] $micrositios
 * @property Pagina[] $paginas
 * @property Seccion[] $seccions
 */
class Url extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Url the static model class
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
		return 'url';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('slug, tipo, creado, estado', 'required'),
			array('tipo, estado', 'numerical', 'integerOnly'=>true),
			array('slug', 'length', 'max'=>255),
			array('creado, modificado', 'length', 'max'=>19),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, slug, tipo, creado, modificado, estado', 'safe', 'on'=>'search'),
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
			'micrositios' => array(self::HAS_MANY, 'Micrositio', 'url_id'),
			'paginas' => array(self::HAS_MANY, 'Pagina', 'url_id'),
			'seccions' => array(self::HAS_MANY, 'Seccion', 'url_id'),
			'url' => array(self::HAS_MANY, 'Url', 'url_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'slug' => 'Slug',
			'tipo' => 'Tipo',
			'creado' => 'Creado',
			'modificado' => 'Modificado',
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
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('tipo',$this->tipo);
		$criteria->compare('creado',$this->creado,true);
		$criteria->compare('modificado',$this->modificado,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
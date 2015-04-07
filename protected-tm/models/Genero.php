<?php

/**
 * This is the model class for table "genero".
 *
 * The followings are the available columns in table 'genero':
 * @property string $id
 * @property string $nombre
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property MicrositioXGenero[] $micrositio_x_genero
 */
class Genero extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Menu the static model class
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
		return 'genero';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, estado', 'required'),
			array('estado', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, estado', 'safe', 'on'=>'search'),
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
			'micrositio_x_genero' => array(self::HAS_MANY, 'MicrositioXGenero', 'genero_id')
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getGeneros($micrositio_id)
	{
		$subquery = Yii::app()->db->createCommand()
			    ->select('mxg.genero_id')
			    ->from('micrositio_x_genero mxg')
			    ->where('mxg.micrositio_id='.$micrositio_id)
			    ->getText();

		$c = new CDbCriteria;
		$c->condition = ' t.id NOT IN ('.$subquery.')';

		return $this->findAll($c);
	}

	protected function beforeDelete()
	{
		try
		{
			foreach($this->micrositio_x_genero as $micrositio_x_genero)
			{
				$mxg = MicrositioXGenero::model()->findByPk($micrositio_x_genero->id);
				$mxg->delete();
			}
			return parent::beforeDelete();
						
		}//try
		catch(Exception $e)
		{
		   return false;
		}
	}

}
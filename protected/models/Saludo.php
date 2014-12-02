<?php

/**
 * This is the model class for table "saludo".
 *
 * The followings are the available columns in table 'saludo':
 * @property integer $id
 * @property string $nombre
 * @property string $email
 * @property string $twitter
 * @property string $video
 * @property string $creado
 * @property integer $estado
 *
 */
class Saludo extends CActiveRecord
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
		return 'saludo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, email, video', 'required'),
			array('estado', 'numerical', 'integerOnly'=>true),
			array('nombre, email', 'length', 'max'=>100),
			array('twitter', 'length', 'max'=>15),
			array('video', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, email, video, creado, estado', 'safe', 'on'=>'search'),
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
			'email' => 'Correo electrónico',
			'twitter' => 'Twitter',
			'video' => 'Video',
			'creado' => 'Creado',
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('twitter',$this->twitter,true);
		$criteria->compare('video',$this->video,true);
		$criteria->compare('creado',$this->creado,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave()
	{
	    if(parent::beforeSave())
	    {
	        
	        if($this->isNewRecord)
	        {
	        	$this->creado = date('Y-m-d H:i:s');
	        	$this->estado = 1;
	        }
	        return true;
	    }
	    else
	        return false;
	}
}
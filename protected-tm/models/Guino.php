<?php

/**
 * This is the model class for table "guino".
 *
 * The followings are the available columns in table 'guino':
 * @property string $id
 * @property string $nombre
 * @property string $guino
 * @property string $guino_mobile
 * @property string $creado
 * @property string $modificado
 * @property string $inicio_publicacion
 * @property string $fin_publicacion
 * @property integer $estado
 *
 */
class Guino extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Guino the static model class
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
		return 'guino';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, guino, guino_mobile, estado', 'required'),
			array('estado', 'numerical', 'integerOnly'=>true),
			array('nombre, guino, guino_mobile', 'length', 'max'=>255),
			array('inicio_publicacion, fin_publicacion', 'length', 'max'=>19),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, guino, guino_mobile, creado, modificado, inicio_publicacion, fin_publicacion, estado', 'safe', 'on'=>'search'),
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
			'guino' => 'Guiño',
			'guino_mobile' => 'Guiño (Móvil)',
			'creado' => 'Creado',
			'modificado' => 'Modificado',
			'inicio_publicacion' => 'Inicio de publicación',
			'fin_publicacion' => 'Fin de la publicación',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('guino',$this->guino,true);
		$criteria->compare('guino_mobile',$this->guino_mobile,true);
		$criteria->compare('creado',$this->creado);
		$criteria->compare('modificado',$this->modificado);
		$criteria->compare('inicio_publicacion',$this->inicio_publicacion);
		$criteria->compare('fin_publicacion',$this->fin_publicacion);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
	            'defaultOrder'=>'estado DESC, creado DESC',
        	),
			'pagination'=>array(
				'pageSize'=>25,
			),
		));
	}

	
	protected function beforeSave()
	{
	    if(parent::beforeSave())
	    {
	        
	        if($this->isNewRecord)
	        {
	        	$this->creado 		= date('Y-m-d H:i:s');
	        }
	        else
	        {
	            $this->modificado	= date('Y-m-d H:i:s');
	        }
	        return true;
	    }
	    else
	        return false;
	}
}
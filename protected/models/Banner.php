<?php

/**
 * This is the model class for table "banner".
 *
 * The followings are the available columns in table 'banner':
 * @property string $id
 * @property string $nombre
 * @property string $imagen
 * @property string $imagen_mobile
 * @property string $contador
 * @property string $fuente
 * @property integer $tamano
 * @property string $color
 * @property string $creado
 * @property string $modificado
 * @property string $inicio_publicacion
 * @property string $fin_publicacion
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Pagina $pagina
 */
class Banner extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Banner the static model class
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
		return 'banner';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, imagen, imagen_mobile, contador, estado', 'required'),
			array('contador, tamano, estado', 'numerical', 'integerOnly'=>true),
			array('nombre, imagen, imagen_mobile, url', 'length', 'max'=>255),
			array('fuente', 'length', 'max'=>100),
			array('color', 'length', 'max'=>7),
			array('fin_contador, inicio_publicacion, fin_publicacion', 'length', 'max'=>19),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, imagen, imagen_mobile, url, creado, modificado, contador, fuente, tamano, color, fin_contador, inicio_publicacion, fin_publicacion, estado', 'safe', 'on'=>'search'),
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
			'imagen' => 'Imagen',
			'imagen_mobile' => 'Imagen (Móvil)',
			'url' => 'Url',
			'contador' => 'Contador',
			'fuente' => 'Fuente',
			'tamano' => 'Tamaño (Fuente)',
			'color' => 'Color (Fuente)',
			'fin_contador' => 'Fin contador',
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
		$criteria->compare('imagen',$this->imagen,true);
		$criteria->compare('imagen_mobile',$this->imagen_mobile,true);
		$criteria->compare('url',$this->url);
		$criteria->compare('contador',$this->contador);
		$criteria->compare('fuente',$this->fuente);
		$criteria->compare('tamano',$this->tamano);
		$criteria->compare('color',$this->color);
		$criteria->compare('fin_contador',$this->fin_contador);
		$criteria->compare('creado',$this->creado);
		$criteria->compare('modificado',$this->modificado);
		$criteria->compare('inicio_publicacion',$this->inicio_publicacion);
		$criteria->compare('fin_publicacion',$this->fin_publicacion);
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
<?php

/**
 * This is the model class for table "album_foto".
 *
 * The followings are the available columns in table 'album_foto':
 * @property string $id
 * @property string $micrositio_id
 * @property string $url_id
 * @property string $nombre
 * @property string $directorio
 * @property string $creado
 * @property string $modificado
 * @property integer $estado
 * @property integer $destacado
 *
 * The followings are the available model relations:
 * @property Url $url
 * @property Micrositio $micrositio
 * @property Foto[] $fotos
 */
class AlbumFoto extends CActiveRecord
{
	protected $oldAttributes;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AlbumFoto the static model class
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
		return 'album_foto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('micrositio_id, nombre, creado, estado, destacado', 'required'),
			array('estado, destacado', 'numerical', 'integerOnly'=>true),
			array('micrositio_id, url_id', 'length', 'max'=>10),
			array('nombre', 'length', 'max'=>45),
			array('modificado', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, micrositio_id, url_id, nombre, directorio, creado, modificado, estado, destacado', 'safe', 'on'=>'search'),
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
			'url' => array(self::BELONGS_TO, 'Url', 'url_id'),
			'micrositio' => array(self::BELONGS_TO, 'Micrositio', 'micrositio_id'),
			'fotos' => array(self::HAS_MANY, 'Foto', 'album_foto_id', 'order' => 'fotos.orden ASC, fotos.destacado DESC'),
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
			'url_id' => 'Url',
			'nombre' => 'Nombre',
			'directorio' => 'Directorio',
			'creado' => 'Creado',
			'modificado' => 'Modificado',
			'estado' => 'Estado',
			'destacado' => 'Destacado',
		);
	}

	public function behaviors()
	{
		return array(
			'galleryBehavior' => array(
	            'class' => 'ext.galleryManager.GalleryBehavior',
	            'idAttribute' => 'id',
	            'versions' => array(
	                'thumb' => array(
	                    'resize' => array(100, null),
	                )
	            )
	        ),
	        'utilities'=>array(
                'class'=>'application.components.behaviors.Utilities'
            )
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
		$criteria->compare('url_id',$this->url_id,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('directorio',$this->directorio,true);
		$criteria->compare('creado',$this->creado,true);
		$criteria->compare('modificado',$this->modificado,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('destacado',$this->destacado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeDelete()
	{
		try
		{
			foreach($this->fotos as $foto)
			{
				$v = Foto::model()->findByPk($foto->id);
				$v->delete();
			}

			return parent::beforeDelete();
						
		}//try
		catch(Exception $e)
		{
		   return false;
		}
	}

	protected function afterDelete()
	{
		
		$url = Url::model()->findByPk($this->url_id);
		$url->delete();

		@rmdir( Yii::getPathOfAlias('webroot').'/images/galeria/' . $this->directorio);

		return parent::afterDelete();
	}

	protected function afterFind()
	{
	    $this->oldAttributes = $this->attributes;
	    return parent::afterFind();
	}

	protected function beforeSave()
	{
	    if(parent::beforeSave())
	    {
	        if($this->isNewRecord)
	        {
	        	$url 			= new Url;
				$slug 			= '#imagenes/' . $this->slugger($this->nombre);
				$slug 			= $this->verificarSlug($slug);
				$url->slug 		= $slug;
				$url->tipo_id 	= 5; //Álbum de fotos
				$url->estado  	= 1;
				$url->save();
				
				$this->url_id = $url->getPrimaryKey();
	        	$this->creado = date('Y-m-d H:i:s');
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

	protected function afterSave()
	{
		if(!$this->isNewRecord)
		{
			if( isset($this->oldAttributes['nombre']) && $this->nombre != $this->oldAttributes['nombre']){
				$url 		= Url::model()->findByPk($this->url_id);
				$slug 		= '#imagenes/' . $this->slugger($this->nombre);
				$slug 		= $this->verificarSlug($slug);
				$url->slug 	= $slug;
				$url->save();

				foreach($this->fotos as $foto)
				{
					$uid 		= $foto->url_id;
					$u 			= Url::model()->findByPk($uid);
					$nslug 		= '#imagenes/' . $this->slugger($this->nombre) . '/' . $this->slugger($foto->nombre);
					$nslug 		= $this->verificarSlug($nslug);
					$u->slug 		= $nslug;
					$u->save();
				}
			}
		}
		parent::afterSave();
	}

}
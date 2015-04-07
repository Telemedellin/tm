<?php

/**
 * This is the model class for table "foto".
 *
 * The followings are the available columns in table 'foto':
 * @property string $id
 * @property string $album_foto_id
 * @property string $src
 * @property string $thumb
 * @property string $nombre
 * @property string $descripcion
 * @property string $ancho
 * @property string $alto
 * @property integer $orden
 * @property string $creado
 * @property string $modificado
 * @property integer $estado
 * @property integer $destacado
 *
 * The followings are the available model relations:
 * @property AlbumFoto $albumFoto
 */
class Foto extends CActiveRecord
{
	protected $oldAttributes;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Foto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function behaviors()
	{
		return array(
			'utilities'=>array(
                'class'=>'application.components.behaviors.Utilities'
            )
		);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'foto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('album_foto_id, url_id, src, thumb, nombre, ancho, alto, estado, destacado', 'required'),
			array('album_foto_id, url_id, orden, estado, destacado', 'numerical', 'integerOnly'=>true),
			array('album_foto_id, ancho, alto', 'length', 'max'=>10),
			array('src, thumb', 'length', 'max'=>255),
			array('nombre', 'length', 'max'=>100),
			array('descripcion, creado, modificado', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, album_foto_id, url_id, src, thumb, nombre, descripcion, ancho, alto, orden, creado, modificado, estado, destacado', 'safe', 'on'=>'search'),
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
			'albumFoto' => array(self::BELONGS_TO, 'AlbumFoto', 'album_foto_id'),
			'url' => array(self::BELONGS_TO, 'Url', 'url_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'album_foto_id' => 'Álbum de fotos',
			'url_id' => 'Url',
			'src' => 'Src',
			'thumb' => 'Miniatura',
			'nombre' => 'Nombre',
			'descripcion' => 'Descripción',
			'ancho' => 'Ancho',
			'alto' => 'Alto',
			'orden' => 'Orden',
			'creado' => 'Creado',
			'modificado' => 'Modificado',
			'estado' => 'Publicado',
			'destacado' => 'Destacado',
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
		$criteria->compare('album_foto_id',$this->album_foto_id,true);
		$criteria->compare('url_id',$this->url_id,true);
		$criteria->compare('src',$this->src,true);
		$criteria->compare('thumb',$this->thumb,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('ancho',$this->ancho,true);
		$criteria->compare('alto',$this->alto,true);
		$criteria->compare('orden',$this->orden,true);
		$criteria->compare('creado',$this->creado,true);
		$criteria->compare('modificado',$this->modificado,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('destacado',$this->destacado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function afterDelete()
	{
		$url = Url::model()->findByPk($this->url_id);
		$url->delete();

		$imagenes = array();
		if( !is_null($this->src) && !empty($this->src) ) 
			$imagenes[] = $this->src;
		if( !is_null($this->thumb) && !empty($this->thumb) ) 
			$imagenes[] = $this->thumb;
		
		if(isset($imagenes))
			foreach($imagenes as $imagen)
				@unlink( Yii::getPathOfAlias('webroot').'/images/galeria/' . $this->albumFoto->directorio . $imagen);
		
		return parent::afterDelete();
	}

	protected function afterFind()
	{
	    $this->oldAttributes = $this->attributes;
	    return parent::afterFind();
	}

	protected function beforeSave()
	{
	    
        if($this->isNewRecord)
        {
        	$album_foto= AlbumFoto::model()->findByPk($this->album_foto_id);
			$url 	   = new Url;
			$slug 	   = '#imagenes/'.$this->slugger($album_foto->nombre).'/'.$this->slugger($this->nombre);
			$slug 	   = $this->verificarSlug($slug);
			$url->slug = $slug;
			$url->tipo_id 	= 9; //Video
			$url->estado  	= 1;
			if( $url->save() )
				$this->url_id = $url->getPrimaryKey();
			else
				return false;
        	$this->creado 		= date('Y-m-d H:i:s');
        }
        else
        {
            $this->modificado	= date('Y-m-d H:i:s');
        }
	    return parent::beforeSave();
	}

	protected function afterSave()
	{
		if(!$this->isNewRecord)
		{
			if( isset($this->oldAttributes['nombre']) && $this->nombre != $this->oldAttributes['nombre']){
				$url = Url::model()->findByPk($this->url_id);
				$slug = '#imagenes/' . $this->slugger($this->albumFoto->nombre).'/'.$this->slugger($this->nombre);
				$slug = $this->verificarSlug($slug);
				$url->slug 	= $slug;
				$url->save();
			}

		}
		parent::afterSave();
	}
}
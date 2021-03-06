<?php

/**
 * This is the model class for table "menu_item".
 *
 * The followings are the available columns in table 'menu_item':
 * @property integer $id
 * @property integer $menu_id
 * @property integer $tipo_link_id
 * @property integer $url_id
 * @property integer $orden
 * @property integer $item_id
 * @property integer $hijos
 * @property string $label
 * @property string $url
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Menu $menu
 * @property TipoLink $tipoLink
 */
class MenuItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MenuItem the static model class
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
		return 'menu_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('menu_id, tipo_link_id, label, estado', 'required'),
			array('url_id, orden, hijos, estado', 'numerical', 'integerOnly'=>true),
			array('menu_id, tipo_link_id, item_id', 'length', 'max'=>10),
			array('label', 'length', 'max'=>100),
			array('url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, menu_id, tipo_link_id, url_id, orden, item_id, hijos, label, url, estado', 'safe', 'on'=>'search'),
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
			'menu' => array(self::BELONGS_TO, 'Menu', 'menu_id'),
			'tipoLink' => array(self::BELONGS_TO, 'TipoLink', 'tipo_link_id'),
			'urlx' => array(self::BELONGS_TO, 'Url', 'url_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'menu_id' => 'Menu',
			'tipo_link_id' => 'Tipo Link',
			'url_id' => 'URL',
			'orden' => 'Orden',
			'item_id' => 'Item',
			'hijos' => 'Hijos',
			'label' => 'Título',
			'url' => 'Url externa',
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
		$criteria->compare('menu_id',$this->menu_id,true);
		$criteria->compare('tipo_link_id',$this->tipo_link_id,true);
		$criteria->compare('url_id',$this->url_id,true);
		$criteria->compare('orden',$this->orden,true);
		$criteria->compare('item_id',$this->item_id,true);
		$criteria->compare('hijos',$this->hijos);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function crear_item_inicio($pagina, $label = 'Inicio')
	{
		$mi = new MenuItem;
		$mi->menu_id = $pagina->micrositio->menu_id;
		$mi->tipo_link_id = 1;
		$mi->url_id = $pagina->url_id;
		$mi->orden = 0;
		$mi->label = $label;
		$mi->estado = 1;
		if( $mi->save() )
			return true;
		else
			return false;
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
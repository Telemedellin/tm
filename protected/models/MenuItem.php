<?php

/**
 * This is the model class for table "menu_item".
 *
 * The followings are the available columns in table 'menu_item':
 * @property string $id
 * @property string $menu_id
 * @property string $tipo_link_id
 * @property string $item_id
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
			array('menu_id, tipo_link_id, label, url, estado', 'required'),
			array('hijos, estado', 'numerical', 'integerOnly'=>true),
			array('menu_id, tipo_link_id, item_id', 'length', 'max'=>10),
			array('label', 'length', 'max'=>100),
			array('url', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, menu_id, tipo_link_id, item_id, hijos, label, url, estado', 'safe', 'on'=>'search'),
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
			'item_id' => 'Item',
			'hijos' => 'Hijos',
			'label' => 'Label',
			'url' => 'Url',
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
		$criteria->compare('menu_id',$this->menu_id,true);
		$criteria->compare('tipo_link_id',$this->tipo_link_id,true);
		$criteria->compare('item_id',$this->item_id,true);
		$criteria->compare('hijos',$this->hijos);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
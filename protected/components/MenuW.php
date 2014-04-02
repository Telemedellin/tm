<?php
Yii::import('system.web.widgets.CWidget');

class MenuW extends CWidget
{
    public  $id;
    private $menu = array();

    public function run()
    {
        $this->getItems();
        $this->widget('zii.widgets.CMenu', array('items' => $this->menu) );
    }

    protected function getItems()
    {
    	$ru = Yii::app()->request->requestUri;

        $c = new CDbCriteria;
        $c->addCondition('t.estado <> 0');
        $c->addCondition('menuItems.estado <> 0');
        $c->order  = 'menuItems.orden ASC';

    	$menu = Menu::model()->with('menuItems')->findByPk($this->id, $c);
    	$items = $menu->menuItems;
        if($items)
        {
        	foreach($items as $item)
        	{
        		if($item->item_id != 0) continue;
                $actual = $this->build($item);

                $this->menu[] = $actual;
        	}
        }//if($items)
    }

    protected function getSubItems($item_id)
    {
    	$dependencia = new CDbCacheDependency("SELECT GREATEST(MAX(creado), MAX(modificado)) FROM menuItem WHERE estado = 1");

        $c = new CDbCriteria;
        $c->addCondition('t.estado <> 0');
        $c->order  = 't.orden ASC';
        $menu_items = MenuItem::model()->cache(21600, $dependencia)->findAllByAttributes( array('item_id' => $this->id), $c );
        return ($menu_items) ? $menu_items : false;
    }

    protected function getUrl($item)
    {
        if(!$item) return false;

        switch($item->tipo_link_id)
        {
            case 1:
                $u = Url::model()->findByPk( $item->url_id );
                $url = bu($u->slug);
                break;
            case 2:
                $url = $this->parseExtUrl( $item->url );
                break;
        }
        return $url;
    }

    protected function build($item)
    {
        $url = $this->getUrl($item);

        $actual = array(
                'label' => (isset($item->label))?$item->label:$item->nombre,
                'url'   => $url,
                'itemOptions' => array('class' => (isset($item->clase))?$item->clase:'' ),
                'active'=> strpos($ru, $url)
            );
        if(isset($item->tipo_link_id) && $item->tipo_link_id == 2)
            $actual['linkOptions'] = array('target' => '_blank');
        
        if($item->hijos == 1)
        {
            $hijos = $this->getSubItems($item->item_id);
            $subitems = array();
            foreach($hijos as $hijo)
            {
                $subitems[] = $this->build($hijo);
            }
            $actual['items'] = $subitems;
        }
       
       return $actual;
    }

    protected function parseUrl($url)
    {
        if( strpos($url, '/') !== 0 ) $url = '/' . $url;
        return $url;
    }

    protected function parseExtUrl($url)
    {
       return $url; 
    }
}
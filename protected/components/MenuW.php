<?php
Yii::import('system.web.widgets.CWidget');

class MenuW extends CWidget
{
    public $id;

    public function run()
    {
        $items = $this->getItems();
        $this->widget('zii.widgets.CMenu', array('items' => $items) );
    }

    protected function getItems()
    {
    	$ru = Yii::app()->request->requestUri;

        $c = new CDbCriteria;
        $c->addCondition('t.estado <> 0');
        $c->addCondition('menuItems.estado = 1');
        $c->order  = 'menuItems.orden ASC';

    	$menu = Menu::model()->with('menuItems')->findByPk($this->id, $c);
    	$items = $menu->menuItems;
    	$items_menu = array();
    	foreach($items as $item)
    	{
    		if($item->item_id != 0) continue;
            $url = $this->getUrl($item);
            $clase = $item->clase;
            
    		$item_actual = array(
    				'label' => $item->label,
    				'url'	=> $url,
                    'itemOptions' => array('class' => $clase),
    				'active'=> strpos($ru, $url)
    			);
            if($item->tipo_link_id == 2)
                $item_actual['linkOptions'] = array('target' => '_blank');
    		if($item->hijos == 1)
    		{
    			$hijos = $this->getSubItems($item->item_id);
    			$subitems = array();
    			foreach($hijos as $hijo)
    			{
    				$hurl = $this->getUrl($hijo);
                    $hclase = $hijo->clase;
                    $subitems[] = array(
    						'label' => $hijo->label,
    						'url'	=> $hurl,
                            'itemOptions' => array('class' => $hclase),
    						'active' => strpos($ru, $hurl)
    					);
                    if($hijo->tipo_link_id == 2){
                        $subitems[key(end($a))]['linkOptions'] = array('target' => '_blank');
                    }
    			}
    			$item_actual['items'] = $subitems;
    		}
    		$items_menu[] = $item_actual;
    	}
    	return $items_menu;
    }

    protected function getSubItems($item_id)
    {
    	$c = new CDbCriteria;
        $c->addCondition('t.estado <> 0');
        $c->order  = 't.orden ASC';
        return MenuItem::model()->findAllByAttributes( array('item_id' => $this->id), $c );
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
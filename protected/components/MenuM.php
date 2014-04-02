<?php
Yii::import('system.web.widgets.CWidget');

class MenuM extends CWidget
{
    public  $id;
    private $menu = array();

    public function run()
    {
        $this->getItems();
        $programacion = array(
                'label' => 'Programación',
                'url'   => bu('programacion'),
                'active'=> strpos($ru, 'programacion'), 
                'class' => 'programacion'
            );
        $uno = array_shift($this->menu);
        $dos = array_shift($this->menu);
        array_unshift($this->menu, $programacion);
        array_unshift($this->menu, $dos);
        array_unshift($this->menu, $uno);
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

    protected function getHijos($url_id)
    {
    	$dependencia = new CDbCacheDependency("SELECT GREATEST(MAX(micrositio.creado), MAX(micrositio.modificado)) FROM micrositio WHERE micrositio.estado <> 0");

        $c = new CDbCriteria;
        $c->addCondition('t.estado <> 0');
        $c->addCondition('micrositios.estado <> 0');
        if($url_id == 1) $c->order  = 'micrositios.creado DESC';
        else $c->order  = 't.nombre ASC';
        
        $seccion = Seccion::model()->cache(21600, $dependencia)->with('micrositios')->findByAttributes( array('url_id' => $url_id), $c );
        if($seccion)
        {
            return $seccion->micrositios;
        }
        else
        {
            $c = new CDbCriteria;
            $c->addCondition('t.estado <> 0');
            $c->addCondition('paginas.estado <> 0');
            $c->order  = 't.nombre DESC';
            $micrositio = Micrositio::model()->cache(21600, $dependencia)->with('paginas')->findByAttributes( array('url_id' => $url_id), $c );
            if($micrositio->seccion_id == 1)
                return $micrositio->paginas;
        }
        return false;
    }

    protected function getUrl($item)
    {
        if(!$item) return false;

        if(isset($item->tipo_link_id) && $item->tipo_link_id == 2)
        {
            $url = $this->parseExtUrl( $item->url );
        }else
        {
            $u = Url::model()->findByPk( $item->url_id );
            $url = bu($u->slug);
        }
        return $url;
    }

    protected function build($item)
    {
        $url = $this->getUrl($item);
        $clase = '';
        if(isset($item->clase))
            $clase .= $item->clase;
        
        $actual = array(
                'label' => (isset($item->label))?$item->label:$item->nombre,
                'url'   => $url,
                'active'=> strpos($ru, $url)
            );
        if(isset($item->tipo_link_id) && $item->tipo_link_id == 2)
            $actual['linkOptions'] = array('target' => '_blank');

        $hijos = $this->getHijos($item->url_id);
        if($hijos){
             $clase .= ' parent';
            $subitems = array();
            foreach($hijos as $hijo)
            {
              $subitems[] = $this->build($hijo);
            }
            $actual['items'] = $subitems;
        }

        if($clase != '')
            $actual['itemOptions'] = array('class' => $clase);

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
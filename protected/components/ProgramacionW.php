<?php
Yii::import('system.web.widgets.CWidget');

class ProgramacionW extends CWidget
{
    public function getProgramas()
    {
        $c 		 = Programacion::model()->getCurrent();
        /*if( $c )
        {
            $n	 = Programacion::model()->getNext( $c->hora_fin );
            return array('actual' => $c, 'siguiente' => $n);
        }*/
        $n   = Programacion::model()->getNext();
        return array('actual' => $c, 'siguiente' => $n);
        
    }

    public static function getMenu($menu, $administrador = false){
        $hoy = mktime(0, 0, 0, date('m'), date('j'), date('Y'));
        $html = '';
        $html .= ($administrador)? '<ul class="nav nav-tabs nav-justified">':'';
        foreach($menu as $item):
            $c = ( ($item >= $hoy && $item < ($hoy+86400))) ? "active":"";
            $html .= ($administrador)? '<li class="'.$c.'">':'';
            $base = ($administrador) ? bu('administrador/programacion'):bu('programacion');
            $url = $base . '?dia=' . date('j', $item) . '&mes=' . date('m', $item) . '&anio=' . date('Y', $item);
            $clases = ( ($item >= $hoy && $item < ($hoy+86400)) ) ? "hoy ":"";
            $clases .= ( $url == Yii::app()->request->requestUri ) ? "elegido":"";
           
            $html .= '<a href="'.$url.'" class="'.$clases.'">';
            $html .= strftime("%A", $item) . ' ' . strftime("%e", $item);
            $html .= '</a>';
            $html .= ($administrador)?'</li>':'';
        endforeach;
        $html .= ($administrador)?'</ul>':'';
        return $html;
    }

    public function run()
    {
        $this->render('programacionw');
    }
}
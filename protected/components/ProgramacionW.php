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
        $hoy = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $html = '';
        foreach($menu as $item):
            $base = ($administrador) ? bu('administrador/programacion'):bu('programacion');
            $url = $base . '?dia=' . date('d', $item) . '&mes=' . date('m', $item) . '&anio=' . date('Y', $item);
            $clases = ( ($item >= $hoy && $item < ($hoy+86400)) ) ? "hoy ":"";
            $clases .= ( $url == Yii::app()->request->requestUri ) ? "elegido":"";
           
            $html .= '<a href="'.$url.'" class="'.$clases.'">';
            $html .= strftime("%A", $item) . ' ' . strftime("%d", $item);
            $html .= '</a>';
        endforeach;
        return $html;
    }

    public function run()
    {
        $this->render('programacionw');
    }
}
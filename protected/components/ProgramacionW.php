<?php
Yii::import('system.web.widgets.CWidget');

class ProgramacionW extends CWidget
{
    public function getProgramas()
    {
        $c = Programacion::model()->getCurrent();
        $n = Programacion::model()->getNext();
        return array('actual' => $c, 'siguiente' => $n);
    }

    public static function getMenu($menu, $adm = false){
        date_default_timezone_set('America/Bogota');
        setlocale(LC_ALL, 'es_ES.UTF-8');
        $base = ($adm) ? bu('administrador/programacion'):bu('programacion');
        $hoy = mktime(0, 0, 0, date('m'), date('j'), date('Y'));
        $html = '';
        $manana = $hoy + 86400;
        $ruri = Yii::app()->request->requestUri;
        
        $html .= ($adm)? '<ul class="nav nav-tabs nav-justified">':'';
        foreach($menu as $item):
            $url = $base . '?dia=' . date('j', $item) . '&mes=' . date('m', $item) . '&anio=' . date('Y', $item);
            $h = ($url == $ruri) ? "active" : ( ( ($item >= $hoy && $item < $manana && empty($_GET)) ) ? "active" : "" );
            $html .= ($adm)? '<li class="'.$h.'">':'';
            $clases = ( ($item >= $hoy && $item < $manana) ) ? "hoy ":"";
            $clases .= ( $url == $ruri ) ? "elegido":"";
            $html .= '<a href="'.$url.'" class="'.$clases.'">';
            $html .= '<time datetime="' . date("Y-m-d H:i", $item) . '">';
            $html .= ucfirst(strftime("%A", $item)) . ' ' . strftime("%e", $item);
            $html .= '</time>';
            $html .= '</a>';
            $html .= ($adm)?'</li>':'';
        endforeach;
        $html .= ($adm)?'</ul>':'';

        return $html;
    }

    public function run()
    {
        $this->render('programacionw');
    }
}
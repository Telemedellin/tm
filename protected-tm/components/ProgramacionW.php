<?php
Yii::import('system.web.widgets.CWidget');

class ProgramacionW extends CWidget
{
    
    public $layout = 'pc';

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

    public static function getSelect($menu){
        date_default_timezone_set('America/Bogota');
        setlocale(LC_ALL, 'es_ES.UTF-8');
        $base = bu('programacion');
        $hoy = mktime(0, 0, 0, date('m'), date('j'), date('Y'));
        $html = '';
        $manana = $hoy + 86400;
        $ya = false;
        $ruri = Yii::app()->request->requestUri;
        $html .= '<select name="dia_programacion" id="dia_programacion">';
        foreach($menu as $item):
            $selected = '';
            $url = $base . '?dia=' . date('j', $item) . '&mes=' . date('m', $item) . '&anio=' . date('Y', $item);
            if(!$ya)
            {
                if($url == $ruri)
                {
                    $selected = " selected='selected'";
                    $ya = true;
                }elseif($item >= $hoy && $item < $manana){
                    $selected = " selected='selected'";
                }else
                {
                    $selected = '';
                }
            }
            $html .= '<option value="'.$url.'"'.$selected.'>';
            $html .= ucfirst(strftime("%A", $item)) . ' ' . strftime("%e", $item);
            $html .= '</option>';
        endforeach;
        $html .= '</select>';

        return $html;
    }

    public function run()
    {
        if($this->layout == 'pc')
            $this->render('programacionw');
        else
            $this->render('programacionw_'.$this->layout);
    }
}
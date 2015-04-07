<?php
Yii::import('system.web.widgets.CWidget');

class Novedades extends CWidget
{
    public $max = 10;
    public $layout = 'pc';
 
    public function getNovedades()
    {
        return Pagina::model()->listarNovedades( $this->max );
    }

    public function run()
    {
        if($this->layout == 'pc')
            $this->render('novedades');
        else
            $this->render('novedades_'.$this->layout);
    }
}
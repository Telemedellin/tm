<?php
Yii::import('system.web.widgets.CWidget');

class Novedades extends CWidget
{
    public $max = 10;
 
    public function getNovedades()
    {
        $m 		 = Micrositio::model()->findByAttributes( array('slug' => 'novedades') );
        $paginas = Pagina::model()->listarPaginas( $m->id, $this->max );
        return $paginas;
    }

    public function run()
    {
        $this->render('novedades');
    }
}
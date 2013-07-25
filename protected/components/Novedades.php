<?php
Yii::import('system.web.widgets.CWidget');

class Novedades extends CWidget
{
    public $max = 10;
 
    public function getNovedades()
    {
        $m 		 = Micrositio::model()->findByAttributes( array('url_id' => 8) );
        $paginas = Pagina::model()->listarPaginas( $m->id, $this->max );
        return $paginas;
    }

    public function run()
    {
        $this->render('novedades');
    }
}
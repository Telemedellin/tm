<?php
Yii::import('system.web.widgets.CWidget');

class Guinos extends CWidget
{
    public $layout = 'pc';
 
    public function getGuino()
    {
        $ya = date('Y-m-d H:i:s');
        $c = new CDbCriteria();
        $c->condition = 'estado = :estado AND (inicio_publicacion < :inicio_p OR inicio_publicacion IS NULL) AND (fin_publicacion > :fin_p OR fin_publicacion IS NULL)';
        $c->params = array(
            ':estado' => 1,
            'inicio_p' => $ya,
            'fin_p' => $ya,
        );
        $dependencia = new CDbCacheDependency("SELECT GREATEST(MAX(creado), MAX(modificado)) FROM guino WHERE estado = 1 AND (inicio_publicacion < '" . $ya . "' OR inicio_publicacion IS NULL) AND (fin_publicacion > '" . $ya . "' OR fin_publicacion IS NULL)");
        return Guino::model()->cache(3600, $dependencia)->find( $c );
    }

    public function run()
    {
        $this->render('guino');
    }
}
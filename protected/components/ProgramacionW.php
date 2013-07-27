<?php
Yii::import('system.web.widgets.CWidget');

class ProgramacionW extends CWidget
{
    public function getProgramas()
    {
        $c 		 = Programacion::model()->getCurrent();
        if( $c )
        {
            $n	 = Programacion::model()->getNext( $c->hora_fin );
            return array('actual' => $c, 'siguiente' => $n);
        }
        
    }

    public function run()
    {
        $this->render('programacionw');
    }
}
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
        else
        {
            return array('actual' => 'Ninguno', 'siguiente' => 'Ninguno');
        }
    }

    public function run()
    {
        $this->render('programacionw');
    }
}
<?php
Yii::import('system.web.widgets.CWidget');

class Buscador extends CWidget
{
    public function run()
    {
        $this->render('buscador');
    }
}
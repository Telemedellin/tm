<?php
Yii::import('system.web.widgets.CWidget');

class NewsTicker extends CWidget
{
    public function run()
    {
        
        $this->render('newsticker');
    }
}
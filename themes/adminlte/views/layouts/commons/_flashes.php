<?php
foreach(Yii::app()->user->getFlashes() as $key => $message) 
{
    echo '<div class="alert alert-' . $key . ' alert-dismissable"><i class="fa fa-' . $key . '"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' . $message . "</div>\n";
}
?>
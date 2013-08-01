<?php
header('Content-Type: application/json; charset="UTF-8"');
echo CJSON::encode( $contenido );
Yii::app()->end();
?>
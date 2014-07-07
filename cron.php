<?php

$yii=dirname(__FILE__).'/../framework/yii.php';
$config=dirname(__FILE__).'/../protected-tm/config/console.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
require_once('../protected-tm/globals.php'); // Llamo las funciones globales
 
// creating and running console application
Yii::createConsoleApplication($config)->run();
?>
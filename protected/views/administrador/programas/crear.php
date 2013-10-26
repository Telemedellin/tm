<?php
/* @var $this UrlController */
/* @var $model Url */

$this->breadcrumbs=array(
	'Programas'=>array('index'),
	'Crear',
);
?>

<h1>Crear Programa</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
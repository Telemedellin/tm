<?php
/* @var $this UrlController */
/* @var $model Url */

$this->breadcrumbs=array(
	'Programación'=>array('index'),
	'Crear',
);

?>

<h1>Crear Programación</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
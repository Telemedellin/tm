<?php
/* @var $this UrlController */
/* @var $model Url */

$this->breadcrumbs=array(
	'Novedades'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Listar Novedades', 'url'=>array('index')),
	array('label'=>'Administrar Novedades', 'url'=>array('admin')),
);
?>

<h1>Crear Novedad</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
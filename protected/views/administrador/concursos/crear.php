<?php
/* @var $this UrlController */
/* @var $model Url */

$this->breadcrumbs=array(
	'Concursos'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Listar Concursos', 'url'=>array('index')),
	array('label'=>'Administrar Concursos', 'url'=>array('admin')),
);
?>

<h1>Crear Concurso</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
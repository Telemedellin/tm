<?php
/* @var $this UrlController */
/* @var $model Url */

$this->breadcrumbs=array(
	'Concursos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'List Url', 'url'=>array('index')),
	array('label'=>'Create Url', 'url'=>array('create')),
	array('label'=>'View Url', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Url', 'url'=>array('admin')),
);
?>

<h1>Modificar Concurso <?php //echo $model->slug; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
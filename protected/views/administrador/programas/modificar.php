<?php
/* @var $this UrlController */
/* @var $model Url */

$this->breadcrumbs=array(
	'Programas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);
?>

<h1>Modificar Programa <?php echo $model->nombre; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
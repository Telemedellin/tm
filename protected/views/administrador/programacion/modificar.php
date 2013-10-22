<?php
/* @var $this UrlController */
/* @var $model Url */

$this->breadcrumbs=array(
	'Programación'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);
?>

<h1>Modificar programación <?php //echo $model->slug; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
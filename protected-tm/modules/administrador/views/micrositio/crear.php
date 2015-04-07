<?php
/* @var $this MicrositioController */
/* @var $model Micrositio */

$this->breadcrumbs=array(
	'Micrositios'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'List Micrositio', 'url'=>array('index')),
	array('label'=>'Manage Micrositio', 'url'=>array('admin')),
);
?>

<h1>Crear Micrositio</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
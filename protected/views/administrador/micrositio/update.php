<?php
/* @var $this MicrositioController */
/* @var $model Micrositio */

$this->breadcrumbs=array(
	'Micrositios'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Micrositio', 'url'=>array('index')),
	array('label'=>'Create Micrositio', 'url'=>array('create')),
	array('label'=>'View Micrositio', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Micrositio', 'url'=>array('admin')),
);
?>

<h1>Update Micrositio <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
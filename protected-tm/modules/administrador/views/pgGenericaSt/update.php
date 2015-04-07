<?php
/* @var $this PgGenericaStController */
/* @var $model PgGenericaSt */

$this->breadcrumbs=array(
	'Pg Generica Sts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PgGenericaSt', 'url'=>array('index')),
	array('label'=>'Create PgGenericaSt', 'url'=>array('create')),
	array('label'=>'View PgGenericaSt', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PgGenericaSt', 'url'=>array('admin')),
);
?>

<h1>Update PgGenericaSt <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
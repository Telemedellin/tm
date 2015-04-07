<?php
/* @var $this PgGenericaStController */
/* @var $model PgGenericaSt */

$this->breadcrumbs=array(
	'Pg Generica Sts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PgGenericaSt', 'url'=>array('index')),
	array('label'=>'Manage PgGenericaSt', 'url'=>array('admin')),
);
?>

<h1>Create PgGenericaSt</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
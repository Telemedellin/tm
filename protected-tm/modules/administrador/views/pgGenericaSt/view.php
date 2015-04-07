<?php
/* @var $this PgGenericaStController */
/* @var $model PgGenericaSt */

$this->breadcrumbs=array(
	'Pg Generica Sts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PgGenericaSt', 'url'=>array('index')),
	array('label'=>'Create PgGenericaSt', 'url'=>array('create')),
	array('label'=>'Update PgGenericaSt', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PgGenericaSt', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PgGenericaSt', 'url'=>array('admin')),
);
?>

<h1>View PgGenericaSt #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'pagina_id',
		'texto:html',
		'estado',
	),
)); ?>

<?php
/* @var $this MicrositioController */
/* @var $model Micrositio */

$this->breadcrumbs=array(
	'Micrositios'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Micrositio', 'url'=>array('index')),
	array('label'=>'Create Micrositio', 'url'=>array('create')),
	array('label'=>'Update Micrositio', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Micrositio', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Micrositio', 'url'=>array('admin')),
);
?>

<h1>View Micrositio #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'seccion_id',
		'pagina_id',
		'usuario_id',
		'menu_id',
		'url_id',
		'background',
		'miniatura',
		'creado',
		'modificado',
		'estado',
		'destacado',
	),
)); ?>

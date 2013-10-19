<?php
/* @var $this UrlController */
/* @var $model Url */

$this->breadcrumbs=array(
	'Novedades' => array('index'),
	$model->nombre,
);

$this->menu=array(
	array('label'=>'Listar Novedad', 'url'=>array('index')),
	array('label'=>'Crear Novedad', 'url'=>array('create')),
	array('label'=>'Actualizar Novedad', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Borrar Novedad', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Administrar Novedad', 'url'=>array('admin')),
);
?>

<h1>Novedad <?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes'=>array(
		'id',
		'nombre',
		'url.slug',
		'pgArticuloBlogs.entradilla',
		'pgArticuloBlogs.texto:html',
		'pgArticuloBlogs.imagen',
		'pgArticuloBlogs.miniatura',
		'creado',
		'modificado',
		'destacado',
		'estado',
	),
)); ?>

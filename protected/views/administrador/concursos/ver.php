<?php
/* @var $this UrlController */
/* @var $model Url */

$this->breadcrumbs=array(
	'Concursos' => array('index'),
	$model->nombre,
);

$this->menu=array(
	array('label'=>'Listar Concursos', 'url'=>array('index')),
	array('label'=>'Crear Concursos', 'url'=>array('create')),
	array('label'=>'Actualizar Concursos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Borrar Concursos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Administrar Concursos', 'url'=>array('admin')),
);
?>

<h1>Concurso <?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => array('concurso' => $model, 'contenido' => $contenido),
	'attributes'=>array(
		'concurso.nombre',
		'concurso.url.slug',
		'contenido.texto', 
		'concurso.background',
		'concurso.miniatura',
		'concurso.creado',
		'concurso.modificado',
		'concurso.estado',
	),
)); ?>

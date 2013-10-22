<?php
/* @var $this UrlController */
/* @var $model Url */

$this->breadcrumbs=array(
	'Programacion' => array('index'),
	$model->micrositio->nombre,
);
?>

<h1>Programacion</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes'=>array(
		'id',
		'micrositio.nombre',
		array(
            'name'=>'hora_inicio',
            'type'=>'time',
            'value'=>$model->hora_inicio,
        ),
        array(
            'name'=>'hora_fin',
            'type'=>'time',
            'value'=>$model->hora_fin,
        ),
		'estado',
	),
)); ?>

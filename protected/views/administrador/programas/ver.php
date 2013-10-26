<?php
/* @var $this UrlController */
/* @var $model Url */

$this->breadcrumbs=array(
	'Programas' => array('index'),
	$model->nombre,
);
?>

<h1>Concurso <?php echo $model->nombre; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => array('programa' => $model, 'contenido' => $contenido),
	'attributes'=>array(
		'programa.nombre',
		array(
			'name' => 'programa.url.slug',
			'type' => 'html', 
			'value' => '<a href="'.bu($model->url->slug).'" target="_blank">'.$model->url->slug.'</a>'
		),
		'contenido.resena:html', 
		array(
            'name' => 'contenido.horario',
            //'type'=>'time',
            'value' => Horarios::horario_parser($contenido->horario),
        ),
		'programa.background',
		'programa.miniatura',
		'programa.creado',
		'programa.modificado',
		array(
			'name' => 'contenido.estado',
			'value' => ($contenido->estado==2)?'En emisión':(($contenido->estado==1)?'No se emite':'Desactivado'),
		),
		'programa.destacado',
	),
)); ?>

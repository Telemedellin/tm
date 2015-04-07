<?php
/* @var $this MicrositioController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Micrositios',
);

$this->menu=array(
	array('label'=>'Create Micrositio', 'url'=>array('create')),
	array('label'=>'Manage Micrositio', 'url'=>array('admin')),
);
?>

<h1>Micrositios</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'enableSorting' => true,
	'columns'=>array(
        'id',
        array(
            'name'=>'Nombre',
            'value'=>'l($data->nombre, bu($data->url->slug) )',
            'type'=>'html'
        ),
        array(
            'name'=>'Sección',
            'value'=>'l($data->seccion->nombre, bu($data->seccion->url->slug) )',
            'type'=>'html'
        ),
        array(
            'name'=>'background',
            'value'=>'l($data->background, bu($data->background) )',
            'type'=>'html'
        ),
        array(
            'name'=>'miniatura',
            'value'=>'l($data->miniatura, bu($data->miniatura) )',
            'type'=>'html'
        ),
        array(
            'name'=>'creado',
            'value'=>'date("Y-m-d H:i:s", $data->creado)',
        ),
        array(
            'name'=>'modificado',
            'value'=>'date("Y-m-d H:i:s", $data->modificado)',
        ),
        'estado',
        'destacado',
        array(
            'class'=>'CButtonColumn',
        ),
    )
)); ?>
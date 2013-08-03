<?php
/* @var $this PaginaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Páginas',
);

$this->menu=array(
	array('label'=>'Crear Pagina', 'url'=>array('create')),
	array('label'=>'Manage Pagina', 'url'=>array('admin')),
);
?>

<h1>Páginas</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'enableSorting' => true,
	'columns'=>array(
        'id',
        //'usuario.nombre',
        'micrositio.nombre',
        'tipoPagina.nombre',
        'url.slug',
        'nombre',
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


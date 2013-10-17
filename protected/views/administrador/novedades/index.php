<?php
/* @var $this UrlController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Novedades',
);

$this->menu=array(
	array('label'=>'Crear Novedad', 'url'=>array('crear')),
	array('label'=>'Administrar Novedades', 'url'=>array('admin')),
);
?>

<h1>Novedades</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'enableSorting' => true,
	'columns'=>array(
        'id',
        'nombre',
        'creado',
        'modificado',
        'estado',
        array(
            'class'=>'CButtonColumn',
        ),
    )
)); ?>

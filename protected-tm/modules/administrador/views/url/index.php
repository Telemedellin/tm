<?php
/* @var $this UrlController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Urls',
);

$this->menu=array(
	array('label'=>'Crear Url', 'url'=>array('crear')),
	array('label'=>'Manage Url', 'url'=>array('admin')),
);
?>

<h1>Urls</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'enableSorting' => true,
	'columns'=>array(
        'id',
        'slug',
        'tipo',
        array(
            'name'=>'creado',
            'value'=>'date("Y-m-d H:i:s", $data->creado)',
        ),
        array(
            'name'=>'modificado',
            'value'=>'date("Y-m-d H:i:s", $data->modificado)',
        ),
        'estado',
        array(
            'class'=>'CButtonColumn',
        ),
    )
)); ?>

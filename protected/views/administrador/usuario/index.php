<?php
$this->breadcrumbs=array(
	'Usuarios',
);
?>
<h1>Usuarios</h1>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'enableSorting' => true,
	'columns'=>array(
        'id',
        'nombre',
        'correo',
        array(
            'name'=>'creado',
            'value'=>'date("Y-m-d H:i:s", $data->creado)',
        ), 
        'estado',
        'es_admin',
        array(
            'class'=>'CButtonColumn',
        ),
    )
)); ?>
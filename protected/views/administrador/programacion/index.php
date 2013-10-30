<h1>Programación</h1>
<?php echo $menu; ?>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . ' alert-success">' . $message . "</div>\n";
    }
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'enableSorting' => true,
    'pager' => array('pageSize' => 25),
	'columns'=>array(
        'id',
        'micrositio.nombre',
         array(
            'name'=>'hora_inicio',
            'value'=>'date("H:i", $data->hora_inicio)',
        ),
        array(
            'name'=>'hora_fin',
            'value'=>'date("H:i", $data->hora_fin)',
        ),
        array(
            'name'=>'estado',
            'header'=>'Publicado',
            'filter'=>array('1'=>'Si','0'=>'No'),
            'value'=>'($data->estado=="1")?("Si"):("No")'
        ),
        array(
            'class'=>'CButtonColumn',
        ),
    )
)); ?>

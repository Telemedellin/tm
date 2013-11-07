<h1>Novedades</h1>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . ' alert-success">' . $message . "</div>\n";
    }
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'enableSorting' => true,
    'defaultOrder'=>'creado DESC',
	'columns'=>array(
        'id',
        'nombre',
        'creado',
        'modificado',
        array(
            'name'=>'estado',
            'header'=>'Publicado',
            'filter'=>array('1'=>'Si','0'=>'No'),
            'value'=>'($data->estado=="1")?("Si"):("No")'
        ),
        array(
            'name'=>'destacado',
            'filter'=>array('1'=>'Si','0'=>'No'),
            'value'=>'($data->destacado=="1")?("Si"):("No")'
        ),
        array(
            'class'=>'CButtonColumn',
        ),
    )
)); ?>

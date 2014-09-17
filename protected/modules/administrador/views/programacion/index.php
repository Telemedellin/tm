<?php $this->pageTitle = 'Programación' ?>
<h1>Programación</h1>
<?php echo $menu; ?>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . ' alert-success">' . $message . "</div>\n";
    }
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$model->search(),
    'filter' => $model,
	'enableSorting' => true,
    'pager' => array('pageSize' => 25),
	'columns'=>array(
        array(
            'name' => 'id',
            'filter'=> false,
        ),
        //'micrositio.nombre',
        array( 'name'=>'nombre_micrositio', 'value'=>'$data->micrositio->nombre' ),
        array(
            'name'=>'hora_inicio',
            'value'=>'date("H:i", $data->hora_inicio)',
            'filter'=> false,
        ),
        array(
            'name'=>'hora_fin',
            'value'=>'date("H:i", $data->hora_fin)',
            'filter'=> false,
        ),
        array(
            'name'=>'estado',
            'header'=>'Publicado',
            'filter'=>array('1'=>'Si','0'=>'No'),
            'value'=>'($data->estado=="1")?("Si"):("No")'
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{view}{update}{delete}',
            'buttons' => array(
                'update' => array(
                    'visible' => '(Yii::app()->user->checkAccess("editar_programacion"))?true:false', 
                ),
                'delete' => array(
                    'visible' => '(Yii::app()->user->checkAccess("eliminar_programacion"))?true:false', 
                ),
            ),
        ),
    )
)); ?>

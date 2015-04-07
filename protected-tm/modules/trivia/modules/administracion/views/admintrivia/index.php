<?php $this->pageTitle = 'Trivia' ?>
<h1>Trivia</h1>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . ' alert-success">' . $message . "</div>\n";
    }
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider' => $model->search(),
    'filter' => $model, 
	'enableSorting' => true,
	'columns'=>array(
        'id',
        'fecha_inicio',
        'fecha_fin',
        array(
            'header' => 'Preguntas', 
            'value'  => 'count($data->rondaXPreguntas)', 
        ),
        'puntos',
        array(
            'name'=>'estado',
            'header'=>'Publicado',
            'filter'=>array('1'=>'Si','0'=>'No'),
            'value'=>'($data->estado=="1")?("Sí"):("No")'
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{view}{update}{delete}',
            'buttons' => array(
                'update' => array(
                    'visible' => '(Yii::app()->user->checkAccess("editar_trivia"))?true:false', 
                ),
                'delete' => array(
                    'visible' => '(Yii::app()->user->checkAccess("eliminar_trivia"))?true:false', 
                ),
            ),
        ),
    )
)); ?>

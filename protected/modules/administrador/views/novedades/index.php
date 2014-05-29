<?php $this->pageTitle = 'Novedades' ?>
<h1>Novedades</h1>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . ' alert-success">' . $message . "</div>\n";
    }
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'enableSorting' => true,
    //'rowCssClassExpression' => '($data->destacado=="1")?"alert-success":(($data->estado=="2")?"alert-info":(($data->estado=="1")?"alert-warning":"alert-danger"))',
	'columns'=>array(
        'id',
        array(
            'name'=>'nombre',
            'header'=>'Nombre',
            'type' => 'raw', 
            'value'=>'"<strong>".$data->nombre."</strong>"'
        ),
        'creado',
        'modificado',
        array(
            'name'=>'estado',
            'header'=>'Estado',
            'value'=>'($data->estado=="2")?("En home"):(($data->estado=="1")?("Archivado"):("Desactivado"))'
        ),
        array(
            'name'=>'destacado',
            'filter'=>array('1'=>'Si','0'=>'No'),
            'value'=>'($data->destacado=="1")?("Si"):("No")'
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{view}{update}{delete}',
            'buttons' => array(
                'update' => array(
                    'visible' => '(Yii::app()->user->checkAccess("editar_novedades"))?true:false', 
                ),
                'delete' => array(
                    'visible' => '(Yii::app()->user->checkAccess("eliminar_novedades"))?true:false', 
                ),
            ),
        ),
    )
)); ?>

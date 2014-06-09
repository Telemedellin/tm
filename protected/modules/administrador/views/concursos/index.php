<?php $this->pageTitle = 'Concursos' ?>
<h1>Concursos</h1>
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
        'nombre',
        'creado',
        'modificado',
        array(
            'name'=>'estado',
            'header'=>'Publicado',
            'filter'=>array('1'=>'Si','0'=>'No'),
            'value'=>'($data->estado=="2")?("Publicado"):(($data->estado=="1")?("Archivado"):("Desactivado"))'
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{view}{update}{delete}',
            'buttons' => array(
                'update' => array(
                    'visible' => '(Yii::app()->user->checkAccess("editar_concursos"))?true:false', 
                ),
                'delete' => array(
                    'visible' => '(Yii::app()->user->checkAccess("eliminar_concursos"))?true:false', 
                ),
            ),
        ),
    )
)); ?>

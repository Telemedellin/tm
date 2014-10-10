<?php $this->pageTitle = 'Guiños' ?>
<h1>Guiños</h1>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . ' alert-success">' . $message . "</div>\n";
    }
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$model->search(),
    'filter' => $model, 
	'enableSorting' => true,
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
        'inicio_publicacion',
        'fin_publicacion',
        array(
            'name'=>'estado',
            'header'=>'Publicado',
            'value'=>'($data->estado=="1")?("Sí"):("No")',
            'filter' => array('1' => 'Sí', '2' => 'No'),
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{view}{update}{delete}',
            'buttons' => array(
                'view' => array(
                    'url' => 'Yii::app()->createUrl("/administrador/guino/view", array("id"=>$data->id))', 
                ),
                'update' => array(
                    'url' => 'Yii::app()->createUrl("/administrador/guino/update", array("id"=>$data->id))', 
                    'visible' => '(Yii::app()->user->checkAccess("editar_guinos"))?true:false', 
                ),
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("/administrador/guino/delete", array("id"=>$data->id))', 
                    'visible' => '(Yii::app()->user->checkAccess("eliminar_guinos"))?true:false', 
                ),
            ),
        ),
    )
)); ?>

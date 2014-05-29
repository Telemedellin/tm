<?php $this->pageTitle = 'Menús'; ?>
<h1>Menús</h1>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . ' alert-success">' . $message . "</div>\n";
    }
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'enableSorting' => true,
    'columns'=>array(
        'nombre',
        array(
            'header' => 'Micrositios asignados', 
            'value' => 
            function($data){
                $r=''; 
                foreach($data->micrositios as $m) 
                    $r .= $m->nombre.', '; 
                return substr($r, 0, -2);
            }
        ),
        'creado',
        'modificado',
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
                    'visible' => '(Yii::app()->user->checkAccess("editar_menus"))?true:false', 
                ),
                'delete' => array(
                    'visible' => '(Yii::app()->user->checkAccess("eliminar_menus"))?true:false', 
                ),
            ),
        ),
    )
)); ?>

<?php if(Yii::app()->user->checkAccess('crear_preguntas')): ?>
<div class="btn-group pull-right">
  <?php echo l('Agregar pregunta', bu('trivia/administracion/pregunta/crear/' . $model->id), array('target' => '_blank', 'class' => 'btn btn-default btn-sm'))?>
</div>
<?php endif ?>
<?php if($preguntas->getData()): ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'  => $preguntas,
    'enableSorting' => true,
    'pager'         => array('pageSize' => 25),
    'htmlOptions'   => array('style' => 'clear:both;'), 
    'columns'       => array(
        'pregunta',
        array(
            'class'=>'CButtonColumn',
            'template'  => '{update}{delete}',
            'buttons'   => array(
                'update' => array(
                    'url'       => 'Yii::app()->createUrl("/trivia/administracion/pregunta/update", array("id"=>$data->id))', 
                    'visible'   => '(Yii::app()->user->checkAccess("editar_pregunta"))?true:false', 
                ),
                /*'delete' => array(
                    'url'       => 'Yii::app()->createUrl("/administrador/pagina/delete", array("id"=>$data->id))',
                    'visible'   => '(Yii::app()->user->checkAccess("eliminar_paginas"))?true:false', 
                ),/**/
            ),
        ),
    )
)); ?>
<?php endif; ?>
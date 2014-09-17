<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$contenido['contenido'],
	'attributes'=>array(
		array(
			'name' => 'imagen', 
			'type' => 'raw', 
			'value' => l($contenido['contenido']->imagen, bu('images/'.$contenido['contenido']->imagen), array('target' => '_blank')),
		),
		array(
			'name' => 'imagen_mobile', 
			'type' => 'raw', 
			'value' => l($contenido['contenido']->imagen_mobile, bu('images/'.$contenido['contenido']->imagen_mobile), array('target' => '_blank')),
		),
		array(
			'name' => 'miniatura', 
			'type' => 'raw', 
			'value' => l($contenido['contenido']->miniatura, bu('images/'.$contenido['contenido']->miniatura), array('target' => '_blank')),
		),
	),
)); 
?>
<h2>Bloques</h2>
<p class="pull-right"><?php echo l('Agregar bloque', bu('administrador/bloque/crear/' . $contenido['contenido']->id), array('class' => 'btn btn-default btn-sm', 'target' => '_blank'))?></p>
<?php if($contenido['contenido']['bloques']): ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$contenido['contenido']['bloques']->search(),
	'filter'=>$contenido['contenido']['bloques'], 
	'enableSorting' => true,
    'pager' => array('pageSize' => 25),
    'htmlOptions' => array('style' => 'clear:both;'), 
	'columns'=>array(
        'id',
        'titulo',
        'columnas',
        array(
        	'name' => 'contenido',
        	'type' => 'raw',
        	'value'=> 'substr( strip_tags($data->contenido), )',
        ),
        'orden',
        array(
            'name'=>'estado',
            'header'=>'Publicado',
            'filter'=>array('1'=>'Si','0'=>'No'),
            'value'=>'($data->estado=="1")?("Si"):("No")'
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{update}{delete}',
            'updateButtonUrl' => 'Yii::app()->createUrl("/administrador/bloque/update", array("id"=>$data->id))',
            'deleteButtonUrl' => 'Yii::app()->createUrl("/administrador/bloque/delete", array("id"=>$data->id))',
            'updateButtonOptions' => array('target' => "_blank"),
        ),
    )
)); ?>
<?php endif; ?>
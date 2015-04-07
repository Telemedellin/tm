<h2>Elementos</h2>
<p class="pull-right"><?php echo l('Agregar elemento', bu('administrador/filtro/crearelemento/' . $contenido['contenido']->id), array('class' => 'btn btn-default btn-sm', 'target' => '_blank'))?></p>
<?php if($contenido['contenido']['filtroItems']->getData()): ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$contenido['contenido']['filtroItems'],
	'enableSorting' => true,
    'pager' => array('pageSize' => 25),
    'htmlOptions' => array('style' => 'clear:both;'), 
	'columns'=>array(
        'id',
        'elemento',
        'padre',
        array(
            'name'=>'estado',
            'header'=>'Publicado',
            'filter'=>array('1'=>'Si','0'=>'No'),
            'value'=>'($data->estado=="1")?("Si"):("No")'
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{update}{delete}',
            'updateButtonUrl' => 'Yii::app()->createUrl("/administrador/filtro/modificarelemento", array("id"=>$data->id))',
            'deleteButtonUrl' => 'Yii::app()->createUrl("/administrador/filtro/borrarelemento", array("id"=>$data->id))',
            'updateButtonOptions' => array('target' => "_blank"),
        ),
    )
)); ?>
<?php endif; ?>
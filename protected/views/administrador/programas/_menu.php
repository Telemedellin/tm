<p class="pull-right">
    <?php //echo l('Agregar pagina', bu('administrador/pagina/crear/' . $model->id), array('class' => 'btn btn-default btn-sm', 'role' => 'button'))?>
</p>
<?php if($menu->getData()): ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$menu,
	'enableSorting' => true,
    'pager' => array('pageSize' => 25),
    'htmlOptions' => array('style' => 'clear:both;'), 
	'columns'=>array(
        'label',
        array(
            'name' => 'url_id',
            'type' => 'raw', 
            'value' => 'l($data->urlx->slug, bu($data->urlx->slug), array("target" => "_blank"))'
        ),
        array(
            'name'=>'estado',
            'filter'=>array('1'=>'Si','0'=>'No'),
            'value'=>'($data->estado=="1")?("Si"):("No")'
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{update}',
            'updateButtonUrl' => 'Yii::app()->createUrl("/administrador/menuitem/update", array("id"=>$data->id))',
            'updateButtonOptions' => array('target' => "_blank"),
        ),
    )
)); ?>
<?php endif; ?>
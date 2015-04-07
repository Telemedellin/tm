<p class="pull-right">
    <?php //echo l('Agregar fecha', bu('administrador/fecha_especial/crear/' . $model->id), array('class' => 'btn btn-default btn-sm', 'role' => 'button'))?>
</p>
<?php if($fechas->getData()): ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$fechas,
	'enableSorting' => true,
    'pager' => array('pageSize' => 25),
    'htmlOptions' => array('style' => 'clear:both;'), 
	'columns'=>array(
        'id',
        'fecha', 
        array(
            'name' => 'hora_inicio',
            'value' => 'Horarios::hora($data->hora_inicio, true)'
        ),
        array(
            'name' => 'hora_fin',
            'value' => 'Horarios::hora($data->hora_fin, true)'
        ),
        array(
            'name'=>'estado',
            'filter'=>array('1'=>'Si','0'=>'No'),
            'value'=>'($data->estado=="1")?("Si"):("No")'
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => ''/*'{update}{delete}'*/,
            'updateButtonUrl' => 'Yii::app()->createUrl("/administrador/fecha_especial/update", array("id"=>$data->id))',
            'deleteButtonUrl' => 'Yii::app()->createUrl("/administrador/fecha_especial/delete", array("id"=>$data->id))',
            'viewButtonOptions' => array('target' => "_blank"),
            'updateButtonOptions' => array('target' => "_blank"),
        ),
    )
)); ?>
<?php endif; ?>
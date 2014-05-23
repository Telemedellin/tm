<p class="pull-right">
    <?php echo l('Agregar horario', bu('administrador/horario/crear/' . $model->id), array('class' => 'btn btn-default btn-sm', 'role' => 'button', 'target' => '_blank'))?>
</p>
<?php if($horario->getData()): ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$horario,
	'enableSorting' => true,
    'pager' => array('pageSize' => 25),
    'htmlOptions' => array('style' => 'clear:both;'), 
	'columns'=>array(
        'id',
        array(
        	'name' => 'dia_semana',
        	'value' => 'Horarios::getDiaSemana($data->dia_semana)'
        ),
        array(
        	'name' => 'hora_inicio',
        	'value' => 'Horarios::hora($data->hora_inicio, true)'
        ),
        array(
        	'name' => 'hora_fin',
        	'value' => 'Horarios::hora($data->hora_fin, true)'
        ),
        array(
        	'name' => 'tipoEmision.nombre',
        	'header' => 'Tipo de emisión'
        ),
        array(
            'name'=>'estado',
            'filter'=>array('1'=>'Si','0'=>'No'),
            'value'=>'($data->estado=="1")?("Si"):("No")'
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{update}{delete}',
            'updateButtonUrl' => 'Yii::app()->createUrl("/administrador/horario/update", array("id"=>$data->id))',
            'deleteButtonUrl' => 'Yii::app()->createUrl("/administrador/horario/delete", array("id"=>$data->id))',
            'updateButtonOptions' => array('target' => "_blank"),
        ),
    )
)); ?>
<?php endif; ?>
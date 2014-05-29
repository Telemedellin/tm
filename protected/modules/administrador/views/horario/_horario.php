<?php if(Yii::app()->user->checkAccess('crear_horarios')): ?>
<p class="pull-right">
    <?php echo l('Agregar horario', bu('administrador/horario/crear/' . $model->id), array('class' => 'btn btn-default btn-sm', 'role' => 'button', 'target' => '_blank'))?>
</p>
<?php endif ?>
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
            'buttons'   => array(
                'update' => array(
                    'options'   => array('target' => "_blank"),
                    'url'       => 'Yii::app()->createUrl("/administrador/horario/update", array("id"=>$data->id))', 
                    'visible'   => '(Yii::app()->user->checkAccess("editar_horarios"))?true:false', 
                ),
                'delete' => array(
                    'url'       => 'Yii::app()->createUrl("/administrador/horario/delete", array("id"=>$data->id))',
                    'visible'   => '(Yii::app()->user->checkAccess("eliminar_horarios"))?true:false', 
                ),
            ),
        ),
    )
)); ?>
<?php endif; ?>
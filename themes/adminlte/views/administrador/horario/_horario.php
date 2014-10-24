<div class="row">
    <?php if(Yii::app()->user->checkAccess('crear_horarios')): ?>
    <div class="col-sm-12">
        <div class="nav navbar-right btn-group">
            <?php echo l('<i class="fa fa-plus"></i> Agregar horario', $this->createUrl('crear', array('id' => $model->id)), array('class' => 'btn btn-primary'))?>
        </div>
    </div>
    <?php endif ?>
    <?php if($horario->getData()): ?>
    <div class="col-sm-12">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
    	'dataProvider'=>$horario,
    	'enableSorting' => true,
        'pager' => array('pageSize' => 25),
        'htmlOptions' => array('style' => 'clear:both;'), 
    	'columns'=>array(
            array(
            	'name' => 'dia_semana',
                'type' => 'raw', 
            	'value' => '"<i class=\"fa fa-calendar-o\"></i> " . Horarios::getDiaSemana($data->dia_semana)'
            ),
            array(
            	'name' => 'hora_inicio',
                'type' => 'raw', 
            	'value' => '"<i class=\"fa fa-clock-o\"></i> " . Horarios::hora($data->hora_inicio, true)'
            ),
            array(
            	'name' => 'hora_fin',
                'type' => 'raw', 
            	'value' => '"<i class=\"fa fa-clock-o\"></i> " . Horarios::hora($data->hora_fin, true)'
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
                'template' => '{update} | {delete}',
                'buttons'   => array(
                    'update' => array(
                        'url'       => 'Yii::app()->createUrl("horario/update", array("id"=>$data->id))', 
                        'visible'   => '(Yii::app()->user->checkAccess("editar_horarios"))?true:false', 
                        'imageUrl' => false,
                        'label'    => '<i class="fa fa-pencil"></i>', 
                        'options'  => array('title' => 'Editar'), 
                    ),
                    'delete' => array(
                        'url'       => 'Yii::app()->createUrl("horario/delete", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("eliminar_horarios"))?true:false', 
                        'imageUrl' => false,
                        'label' => '<i class="fa fa-trash-o"></i>', 
                        'options'  => array('title' => 'Eliminar'), 
                    ),
                ),
            ),
        )
    )); ?>
    </div>
    <?php endif; ?>
</div>
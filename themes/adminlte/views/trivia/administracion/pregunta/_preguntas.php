<div class="row">
	<?php if(Yii::app()->user->checkAccess('crear_preguntas')): ?>
    <div class="col-sm-12">
        <div class="nav navbar-right btn-group">
            <?php echo l('<i class="fa fa-plus"></i> Agregar pregunta', $this->createUrl('crear', array('id' =>$model->id) ), array('class' => 'btn btn-primary', 'target' => '_blank'))?>
        </div>
    </div>
    <?php endif ?>
	<?php if($preguntas->getData()): ?>
	<div class="col-sm-12">
		<?php $this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'  => $preguntas,
		    'enableSorting' => true,
		    'pager'         => array('pageSize' => 25),
		    'htmlOptions'   => array('style' => 'clear:both;'), 
		    'columns'       => array(
		        'pregunta',
		        array(
		        	'header' => 'Respuestas', 
		        	'value' => 'count($data->respuestas)',
		        ),
		        array(
		            'class'=>'CButtonColumn',
		            'template'  => '{update} | {delete}',
		            'buttons'   => array(
		                'update' => array(
		                    'url'       => 'Yii::app()->createUrl("/trivia/administracion/pregunta/update", array("id"=>$data->id))', 
		                    'visible'   => '(Yii::app()->user->checkAccess("editar_pregunta"))?true:false', 
			                'imageUrl' => false,
	                        'label'    => '<i class="fa fa-pencil"></i>', 
	                        'options'  => array('title' => 'Editar', 'target' => "_blank"),  
		                ),
		                'delete' => array(
	                        'url'       => 'Yii::app()->createUrl("/trivia/administracion/pregunta/delete", array("id"=>$data->id))',
	                        'visible'   => '(Yii::app()->user->checkAccess("eliminar_pregunta"))?true:false', 
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
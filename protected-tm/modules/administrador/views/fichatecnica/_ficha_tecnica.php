		<h2>Ficha técnica</h2>
		<?php if(Yii::app()->user->checkAccess('crear_ficha_tecnica')): ?>
		<p class="pull-right"><?php echo l('Agregar elemento a la ficha', bu('administrador/fichatecnica/crear/' . $contenido->id), array('class' => 'btn btn-default btn-sm', 'target' => '_blank'))?></p>
		<?php endif ?>
		<?php if($ficha_tecnica->getData()): ?>
		<?php $this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$ficha_tecnica,
			'enableSorting' => true,
		    'pager' => array('pageSize' => 25),
		    'htmlOptions' => array('style' => 'clear:both;'), 
			'columns'=>array(
		        'id',
		        'campo',
		        'valor',
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
		            'buttons'   => array(
		            	'update' => array(
	                        'options'   => array('target' => "_blank"),
	                        'url'       => 'Yii::app()->createUrl("/administrador/fichatecnica/update", array("id"=>$data->id))',
	                        'visible'   => '(Yii::app()->user->checkAccess("editar_ficha_tecnica"))?true:false', 
	                    ),
	                    'delete' => array(
	                        'url'       => 'Yii::app()->createUrl("/administrador/fichatecnica/delete", array("id"=>$data->id))',
	                        'visible'   => '(Yii::app()->user->checkAccess("eliminar_ficha_tecnica"))?true:false', 
	                    ),
	                ),
		        ),
		    )
		)); ?>
		<?php endif; ?>
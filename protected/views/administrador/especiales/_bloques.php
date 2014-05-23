	<p class="pull-right">
		<?php echo l('Agregar bloque', bu('administrador/bloque/crear/' . $model->id), array('class' => 'btn btn-default btn-sm', 'target' => '_blank'))?>
	</p>
	<?php if($bloques->getData()): ?>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$bloques,
		'enableSorting' => true,
	    'pager' => array('pageSize' => 25),
	    'htmlOptions' => array('style' => 'clear:both;'), 
		'columns'=>array(
	        'titulo', 
	        'columnas',
	        'orden',
	        array(
	        	'name' => 'contenido',
	        	'type' => 'html', 
	        	'value' => 'substr($data->contenido, 0, 50). "..."'
	        ),
	        array(
	            'name'=>'estado',
	            'filter'=>array('1'=>'Si','0'=>'No'),
	            'value'=>'($data->estado=="1")?("Si"):("No")'
	        ),
	       
	        array(
	            'class'=>'CButtonColumn',
	            'template' => /*{view}/**/'{update}{delete}',
	            //'viewButtonUrl' => 'Yii::app()->createUrl("/administrador/bloque/view", array("id"=>$data->id))',
	            'updateButtonUrl' => 'Yii::app()->createUrl("/administrador/bloque/update", array("id"=>$data->id))',
	            'deleteButtonUrl' => 'Yii::app()->createUrl("/administrador/bloque/delete", array("id"=>$data->id))',
	            //'viewButtonOptions' => array('target' => "_blank"),
            	'updateButtonOptions' => array('target' => "_blank"),
	        ),
	    )
	)); ?>
	<?php endif; ?>
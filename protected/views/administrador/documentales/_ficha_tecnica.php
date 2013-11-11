<h2>Ficha técnica</h2>
		<p class="pull-right"><?php echo l('Agregar elemento a la ficha', bu('administrador/fichatecnica/crear/' . $contenido->id), array('class' => 'btn btn-default btn-sm'))?></p>
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
		            'updateButtonUrl' => 'Yii::app()->createUrl("/administrador/fichatecnica/update", array("id"=>$data->id))',
		            'deleteButtonUrl' => 'Yii::app()->createUrl("/administrador/fichatecnica/delete", array("id"=>$data->id))',
		        ),
		    )
		)); ?>
		<?php endif; ?>
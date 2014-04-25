	<p class="pull-right">
		<?php echo l('Agregar item de menú', bu('administrador/menu/crearitem/' . $model->id), array('class' => 'btn btn-default btn-sm'))?>
	</p>
	<?php if($menuItems->getData()): ?>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$menuItems,
		'enableSorting' => true,
	    'pager' => array('pageSize' => 25),
	    'htmlOptions' => array('style' => 'clear:both;'), 
		'columns'=>array(
	        'label', 
	        array(
	        	'name' => 'url_id',
	        	'type' => 'html', 
	        	'value' => 'l($data->urlx->slug, bu($data->urlx->slug), array("target" => "_blank"))'
	        ),
	        array(
	            'name'=>'estado',
	            'filter'=>array('1'=>'Si','0'=>'No'),
	            'value'=>'($data->estado=="1")?("Si"):("No")'
	        ),
	        array(
	            'class'=>'CButtonColumn',
	            'template' => '{view}{update}{delete}',
	            'viewButtonUrl' => 'Yii::app()->createUrl("/administrador/menu/viewitem", array("id"=>$data->id))',
	            'updateButtonUrl' => 'Yii::app()->createUrl("/administrador/menu/updateitem", array("id"=>$data->id))',
	            'deleteButtonUrl' => 'Yii::app()->createUrl("/administrador/menu/deleteitem", array("id"=>$data->id))',
	        ),
	    )
	)); ?>
<?php endif; ?>
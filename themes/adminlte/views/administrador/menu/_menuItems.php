<div class="row">
	<?php if(Yii::app()->user->checkAccess('crear_menu_items')): ?>
	<div class="col-sm-12">
        <div class="nav navbar-right btn-group">
        	<?php echo l('<i class="fa fa-plus"></i> Agregar botón de menú', $this->createUrl('crearitem', array('id' => $model->id)), array('class' => 'btn btn-primary'))?>
		</div>
    </div>
	<?php endif ?>
	<?php if($menuItems->getData()): ?>
	<div class="col-sm-12">
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
	        	'value' => 'l("<i class=\"fa fa-external-link\"></i> '.$data->urlx->slug.'", "'.bu($data->urlx->slug).'", array("target" => "_blank"))'
	        ),
	        array(
	            'name'=>'estado',
	            'filter'=>array('1'=>'Si','0'=>'No'),
	            'value'=>'($data->estado=="1")?("Si"):("No")'
	        ),
	        array(
	            'class'=>'CButtonColumn',
	            'template' => '{view} | {update} | {delete}',
	            'buttons'   => array(
	            	'view' => array(
                        'url'       => 'Yii::app()->createUrl("menu/viewitem", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("ver_menu_items"))?true:false', 
                        'imageUrl' => false,
                        'label'    => '<i class="fa fa-search"></i>', 
                        'options'  => array('title' => 'Ver detalles', 'target' => "_blank"),
                    ),
                    'update' => array(
                        'url'       => 'Yii::app()->createUrl("menu/updateitem", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("editar_menu_items"))?true:false', 
                        'imageUrl' => false,
                        'label'    => '<i class="fa fa-pencil"></i>', 
                        'options'  => array('title' => 'Editar', 'target' => "_blank"), 
                    ),
                    'delete' => array(
                        'url'       => 'Yii::app()->createUrl("menu/deleteitem", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("eliminar_menu_items"))?true:false',
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
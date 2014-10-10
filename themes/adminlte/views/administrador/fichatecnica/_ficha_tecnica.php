<div class="row">
	<?php if(Yii::app()->user->checkAccess('crear_ficha_tecnica')): ?>
	<div class="col-sm-12">
        <div class="nav navbar-right btn-group">
            <?php echo l('<i class="fa fa-plus"></i> Agregar elemento a la ficha', bu('administrador/fichatecnica/crear/' . $contenido->id), array('class' => 'btn btn-primary'))?>
        </div>
    </div>
	<?php endif ?>
	<?php if($ficha_tecnica->getData()): ?>
	<div class="col-sm-12">
		<?php $this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$ficha_tecnica,
			'enableSorting' => true,
		    'pager' => array('pageSize' => 25),
		    'htmlOptions' => array('style' => 'clear:both;'), 
			'columns'=>array(
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
		            'template' => '{update} | {delete}',
		            'buttons'   => array(
		            	'update' => array(
	                        'url'       => 'Yii::app()->createUrl("/administrador/fichatecnica/update", array("id"=>$data->id))',
	                        'visible'   => '(Yii::app()->user->checkAccess("editar_ficha_tecnica"))?true:false', 
	                        'imageUrl' => false,
                        	'label'    => '<i class="fa fa-pencil"></i>', 
                        	'options'  => array('title' => 'Editar'),  
	                    ),
	                    'delete' => array(
	                        'url'       => 'Yii::app()->createUrl("/administrador/fichatecnica/delete", array("id"=>$data->id))',
	                        'visible'   => '(Yii::app()->user->checkAccess("eliminar_ficha_tecnica"))?true:false', 
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
<div class="col-sm-12">
	<div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Bloques</h3>
            <div class="box-tools pull-right">
            	 <?php if(Yii::app()->user->checkAccess('crear_bloques')): ?>
            <?php echo l('<i class="fa fa-plus"></i> Nuevo', $this->createUrl('bloque/crear', array('id' => $contenido['contenido']->id)), array('class' => 'btn btn-primary')) ?>
      <?php endif ?>
            </div>
        </div>
        <div class="box-body">
        	<?php if($contenido['contenido']['bloques']): ?>
			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'dataProvider'=>$contenido['contenido']['bloques']->search(),
				'filter'=>$contenido['contenido']['bloques'], 
				'enableSorting' => true,
			    'pager' => array('pageSize' => 25),
			    'htmlOptions' => array('style' => 'clear:both;'), 
				'columns'=>array(
			        'titulo',
			        'columnas',
			        array(
			        	'name' => 'contenido',
			        	'type' => 'raw',
			        	'value'=> 'substr( strip_tags($data->contenido), 0)',
			        ),
			        'orden',
			        array(
			            'name'=>'estado',
			            'header'=>'Publicado',
			            'filter'=>array('1'=>'Sí','0'=>'No'),
			            'value'=>'($data->estado=="1")?("Sí"):("No")'
			        ),
			        array(
			            'class'=>'CButtonColumn',
			            'template' => '{update} | {delete}',
			            'buttons' => array(
			            	'update' => array(
			            		'url' => 'Yii::app()->createUrl("administrador/bloque/update", array("id"=>$data->id))', 
			                    'visible' => '(Yii::app()->user->checkAccess("editar_novedades"))?true:false', 
			                    'imageUrl' => false,
			                    'label'    => '<i class="fa fa-pencil"></i>', 
			                    'options'  => array('title' => 'Editar'),
			                ),
			                'delete' => array(
			                	'url' => 'Yii::app()->createUrl("administrador/bloque/delete", array("id"=>$data->id))', 
			                    'visible' => '(Yii::app()->user->checkAccess("eliminar_novedades"))?true:false', 
			                    'imageUrl' => false,
			                    'label' => '<i class="fa fa-trash-o"></i>', 
			                    'options'  => array('title' => 'Eliminar'),
			                ),
			            ),
			        ),
			    )
			)); ?>
			<?php endif; ?>
		</div>
	</div>
</div>
<div class="row">
	<?php if(Yii::app()->user->checkAccess('crear_videos')): ?>
	<div class="col-sm-12">
        <div class="nav navbar-right btn-group">
            <?php echo l('<i class="fa fa-plus"></i> Agregar video', $this->createUrl('videos/crear/', array('id' => $model->id)), array('class' => 'btn btn-primary'))?>
        </div>
    </div>
	<?php endif ?>
	<?php if($videos->getData()): ?>
	<div class="col-sm-12">
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$videos,
		'enableSorting' => true,
	    'pager' => array('pageSize' => 25),
	    'htmlOptions' => array('style' => 'clear:both;'), 
		'columns'=>array(
	        'id',
	        'nombre', 
	        array(
	        	'name' => 'url_id',
	        	'type' => 'html', 
	        	'value' => 'l("<i class=\"fa fa-external-link\"></i> '.bu($model->micrositio->url->slug).'" . $data->url->slug, "'.bu($model->micrositio->url->slug).'" . $data->url->slug, array("target" => "_blank"))'
	        ),
	        'proveedorVideo.nombre',
	        array(
	        	'name' => 'url_video',
	        	'type' => 'html', 
	        	'value' => 'l("<i class=\"fa fa-external-link\"></i> ".$data->url_video, $data->url_video, array("target" => "_blank"))'
	        ),
	        array(
	            'name'=>'estado',
	            'filter'=>array('' => 'Todos', '1'=>'Publicado','0'=>'Desactivado'),
	            'value'=>'($data->estado=="1")?("Publicado"):("Desactivado")'
	        ),
	        array(
	            'name'=>'destacado',
	            'filter'=>array('' => 'Todos', '1'=>'Sí','0'=>'No'),
	            'value'=>'($data->destacado=="1")?("Si"):("No")'
	        ),
	        array(
	            'class'=>'CButtonColumn',
	            'template' => '{view} | {update} | {delete}',
	            'buttons'   => array(
	            	'view' => array(
	            		'label' 	=> '<i class="fa fa-search"></i>', 
	            		'imageUrl'	=> false, 
	                    'options'   => array('title' => 'Ver detalles'),
	                    'url'       => 'Yii::app()->createUrl("administrador/videos/view", array("id"=>$data->id))',
	                    'visible'   => '(Yii::app()->user->checkAccess("ver_videos"))?true:false', 
	                ),
	                'update' => array(
	                    'options'  => array('title' => 'Editar'), 
	                    'url'       => 'Yii::app()->createUrl("administrador/videos/update", array("id"=>$data->id))',
	                    'visible'   => '(Yii::app()->user->checkAccess("editar_videos"))?true:false', 
	                    'imageUrl'  => false,
	                    'label'    => '<i class="fa fa-pencil"></i>', 
	                ),
	                'delete' => array(
	                    'url'       => 'Yii::app()->createUrl("administrador/videos/delete", array("id"=>$data->id))',

	                    'visible'   => '(Yii::app()->user->checkAccess("eliminar_videos"))?true:false', 
	                    'imageUrl'  => false,
	                    'label' 	=> '<i class="fa fa-trash-o"></i>', 
	                    'options'  	=> array('title' => 'Eliminar'), 
	                ),
	            ),
	        ),
	    )
	)); ?>
	</div>
	<?php endif; ?>
</div>
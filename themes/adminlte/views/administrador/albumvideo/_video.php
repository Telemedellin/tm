<div class="row">
	<?php if(Yii::app()->user->checkAccess('crear_album_videos')): ?>
	<div class="col-sm-12">
        <div class="nav navbar-right btn-group">
            <?php echo l('<i class="fa fa-plus"></i> Agregar álbum de videos', $this->createUrl('albumvideo/crear', array('id' => $model->id)), array('class' => 'btn btn-primary'))?>
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
	        array(
	        	'name' => 'nombre',
	        	'type' => 'html', 
	        	'value' => '$data->nombre . " <span class=\"badge bg-olive\">" . count($data->videos) . "</span>"'
	        ),
	        array(
	        	'name' => 'url_id',
	        	'type' => 'html', 
	        	'value' => 'l("<i class=\"fa fa-external-link\"></i> '.$model->url->slug.'" . $data->url->slug, "'.bu($model->url->slug).'" . $data->url->slug, array("target" => "_blank"))'
	        ),
	        array(
	            'name'=>'estado',
	            'filter'=>array('' => 'Todos', '1'=>'Publicado','0'=>'Desactivado'),
	            'value'=>'($data->estado=="1")?("Publicado"):("Desactivado")'
	        ),
	        array(
	            'name'=>'destacado',
	            'filter'=>array('' => 'Todos', '1'=>'Sí','0'=>'No'),
	            'value'=>'($data->destacado=="1")?("Sí"):("No")'
	        ),
	        array(
	            'class'=>'CButtonColumn',
	            'template' => '{view} | {update} | {delete}',
	            'buttons'   => array(
	            	'view' => array(
                        'url'       => 'Yii::app()->createUrl("administrador/albumvideo/view", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("ver_album_videos"))?true:false', 
                        'imageUrl' => false,
                        'label'    => '<i class="fa fa-search"></i>', 
                        'options'  => array('title' => 'Ver detalles'),
                    ),
                    'update' => array(
                        'url'       => 'Yii::app()->createUrl("administrador/albumvideo/update", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("editar_album_videos"))?true:false', 
                        'imageUrl' => false,
                        'label'    => '<i class="fa fa-pencil"></i>', 
                        'options'  => array('title' => 'Editar'), 
                    ),
                    'delete' => array(
                        'url'       => 'Yii::app()->createUrl("administrador/albumvideo/delete", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("eliminar_album_videos"))?true:false', 
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
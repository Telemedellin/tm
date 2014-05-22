<div class="row">
	<div class="col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li><?php echo l('<span class="glyphicon glyphicon-chevron-left"></span> Volver', bu('administrador/albumvideo/view/'. $model->id))?></li>
		  <li><?php echo l('<span class="glyphicon glyphicon-pencil"></span> Editar', bu('administrador/albumvideo/update/' . $model->id))?></li>
		  <li><?php echo l('<small><span class="glyphicon glyphicon-remove"></span> Eliminar</small>', bu('administrador/albumvideo/delete/' . $model->id), array('onclick' => 'if( !confirm(¿"Seguro que desea borrar el album "<?php echo $model->nombre; ?>") ) {return false;}'))?></li>
		</ul>
	</div>
	<div class="col-sm-10">
		<h1>Album de video <?php echo $model->nombre; ?> (<?php echo $model->micrositio->nombre ?>)</h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data' => $model,
			'attributes'=>array(
				'nombre',
				array(
					'name' => 'url.slug',
					'type' => 'raw', 
					'value' => l($model->url->slug, bu($model->micrositio->url->slug . $model->url->slug), array('target' => '_blank')),
				),
				array(
					'name' => 'thumb', 
					'type' => 'raw', 
					'value' => l($model->thumb, bu('images/'.$model->thumb), array('target' => '_blank', 'class' => 'fancybox')),
				),
				'creado',
				'modificado',
				array(
					'name' => 'estado',
					'value' => ($model->estado==1)?'Si':'No',
				),
				'destacado:boolean',
			),
		)); ?>
		<h2>Videos</h2>
		<p class="pull-right"><?php echo l('Agregar video', bu('administrador/videos/crear/' . $model->id), array('class' => 'btn btn-default btn-sm', 'target' => '_blank'))?></p>
		<?php if($videos->getData()): ?>
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
		        	'value' => 'l($data->url->slug, "'.bu($model->micrositio->url->slug).'" . $data->url->slug)'
		        ),
		        'proveedorVideo.nombre',
		        array(
		        	'name' => 'url_video',
		        	'type' => 'html', 
		        	'value' => 'l($data->url_video, $data->url_video)'
		        ),
		        array(
		            'name'=>'estado',
		            'filter'=>array('1'=>'Si','0'=>'No'),
		            'value'=>'($data->estado=="1")?("Si"):("No")'
		        ),
		        array(
		            'name'=>'destacado',
		            'filter'=>array('1'=>'Si','0'=>'No'),
		            'value'=>'($data->destacado=="1")?("Si"):("No")'
		        ),
		        array(
		            'class'=>'CButtonColumn',
		            'template' => '{view}{update}{delete}',
		            'viewButtonUrl' => 'Yii::app()->createUrl("/administrador/videos/view", array("id"=>$data->id))',
		            'updateButtonUrl' => 'Yii::app()->createUrl("/administrador/videos/update", array("id"=>$data->id))',
		            'deleteButtonUrl' => 'Yii::app()->createUrl("/administrador/videos/delete", array("id"=>$data->id))',
		            'viewButtonOptions' => array('target' => "_blank"),
            		'updateButtonOptions' => array('target' => "_blank"),
		        ),
		    )
		)); ?>
	<?php endif; ?>
	</div>
</div>
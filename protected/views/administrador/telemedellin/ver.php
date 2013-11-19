<div class="row">
	<div class="col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li><?php echo l('Volver', bu('administrador/telemedellin'))?></li>
		  <li><?php echo l('Editar', bu('administrador/telemedellin/update/' . $model->id))?></li>
		  <li><small><?php echo l('Eliminar', bu('administrador/telemedellin/delete/' . $model->id), array('onclick' => 'if( !confirm(¿"Seguro que desea borrar la novedad "<?php echo $model->nombre; ?>") ) {return false;}'))?></small></li>
		</ul>
	</div>
	<div class="col-sm-10">
		<h1>Telemedellín <?php echo $model->nombre; ?></h1>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data' => $model,
			'attributes'=>array(
				'nombre',
				array(
					'name' => 'url.slug',
					'type' => 'raw', 
					'value' => l($model->url->slug, bu($model->url->slug), array('target' => '_blank')),
				),
				array(
					'name' => 'background', 
					'type' => 'raw', 
					'value' => l($model->background, bu('images/'.$model->background), array('target' => '_blank', 'class' => 'fancybox')),
				),
				array(
					'name' => 'miniatura', 
					'type' => 'raw', 
					'value' => l($model->miniatura, bu('images/'.$model->miniatura), array('target' => '_blank', 'class' => 'fancybox')),
				),
				'creado',
				'modificado',
				array(
					'name' => 'estado',
					'value' => (($model->estado==1)?'Si':'No'),
				),
				'destacado:boolean',
			),
		)); ?>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<h2>Páginas</h2>
		<p class="pull-right">
		    <?php echo l('Agregar página', bu('administrador/pagina/crear/' . $model->id), array('class' => 'btn btn-default btn-sm', 'role' => 'button'))?>
		</p>
		<?php $this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$contenido,
			'enableSorting' => true,
		    'pager' => array('pageSize' => 25),
		    'htmlOptions' => array('style' => 'clear:both;'), 
			'columns'=>array(
		        'id',
		        'nombre',
		        'creado',
		        'modificado',
		        array(
		            'name'=>'estado',
		            'header'=>'Publicado',
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
		            'viewButtonUrl' => 'Yii::app()->createUrl("/administrador/pagina/view", array("id"=>$data->id))',
		            'updateButtonUrl' => 'Yii::app()->createUrl("/administrador/pagina/update", array("id"=>$data->id))',
		            'deleteButtonUrl' => 'Yii::app()->createUrl("/administrador/pagina/delete", array("id"=>$data->id))',
		        ),
		    )
		)); ?>
	</div>
</div>
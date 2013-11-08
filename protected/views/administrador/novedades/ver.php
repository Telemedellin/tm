<div class="row">
	<div class="col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li><?php echo l('Volver', bu('administrador/novedades'))?></li>
		  <li><?php echo l('Editar', bu('administrador/novedades/update/' . $model->id))?></li>
		  <li><small><?php echo l('Eliminar', bu('administrador/novedades/delete/' . $model->id), array('onclick' => 'if( !confirm(¿"Seguro que desea borrar la novedad "<?php echo $model->nombre; ?>") ) {return false;}'))?></small></li>
		</ul>
	</div>
	<div class="col-sm-10">
		<h1>Novedad "<?php echo $model->nombre; ?>"</h1>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data' => $model,
			'attributes'=>array(
				'id',
				'nombre',
				array(
					'name' => 'url.slug', 
					'type' => 'raw', 
					'value' => l($model->url->slug, bu($model->url->slug), array('target' => '_blank')),
				),
				'pgArticuloBlogs.entradilla:html',
				'pgArticuloBlogs.texto:html',
				array(
					'name' => 'pgArticuloBlogs.enlace', 
					'type' => 'raw', 
					'value' => l($model->pgArticuloBlogs->enlace, $model->pgArticuloBlogs->enlace, array('target' => '_blank')),
				),
				array(
					'name' => 'pgArticuloBlogs.imagen', 
					'type' => 'raw', 
					'value' => l($model->pgArticuloBlogs->imagen, bu('images/'.$model->pgArticuloBlogs->imagen), array('target' => '_blank', 'class' => 'fancybox')),
				),
				array(
					'name' => 'pgArticuloBlogs.miniatura', 
					'type' => 'raw', 
					'value' => l($model->pgArticuloBlogs->miniatura, bu('images/'.$model->pgArticuloBlogs->miniatura), array('target' => '_blank', 'class' => 'fancybox')),
				),
				'creado',
				'modificado',
				'estado:boolean',
				'destacado:boolean'
			),
		)); ?>
	</div>
</div>

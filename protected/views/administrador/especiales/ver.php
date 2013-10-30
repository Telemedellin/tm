<div class="row">
	<div class="col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li><?php echo l('Volver', bu('administrador/especiales'))?></li>
		  <li><?php echo l('Editar', bu('administrador/especiales/update/' . $model->id))?></li>
		  <li><small><?php echo l('Eliminar', bu('administrador/especiales/delete/' . $model->id), array('onclick' => 'if( !confirm(¿"Seguro que desea borrar la novedad "<?php echo $model->nombre; ?>") ) {return false;}'))?></small></li>
		</ul>
	</div>
	<div class="col-sm-10">
		<h1>Especial <?php echo $model->nombre; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data' => array('especial' => $model, 'contenido' => $contenido),
			'attributes'=>array(
				'especial.nombre',
				array(
					'name' => 'especial.url.slug',
					'type' => 'raw', 
					'value' => l($model->url->slug, bu($model->url->slug), array('target' => '_blank')),
				),
				'contenido.resena:html', 
				'contenido.lugar', 
				'contenido.presentadores', 
				array(
					'name' => 'especial.background', 
					'type' => 'raw', 
					'value' => l($model->background, bu('images/'.$model->background), array('target' => '_blank', 'class' => 'fancybox')),
				),
				array(
					'name' => 'especial.miniatura', 
					'type' => 'raw', 
					'value' => l($model->miniatura, bu('images/'.$model->miniatura), array('target' => '_blank', 'class' => 'fancybox')),
				),
				'especial.creado',
				'especial.modificado',
				'especial.estado:boolean',
				'especial.destacado:boolean',
			),
		)); ?>
	</div>
</div>
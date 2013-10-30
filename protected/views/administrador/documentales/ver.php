<div class="row">
	<div class="col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li><?php echo l('Volver', bu('administrador/documentales'))?></li>
		  <li><?php echo l('Editar', bu('administrador/documentales/update/' . $model->id))?></li>
		  <li><small><?php echo l('Eliminar', bu('administrador/documentales/delete/' . $model->id), array('onclick' => 'if( !confirm(¿"Seguro que desea borrar la novedad "<?php echo $model->nombre; ?>") ) {return false;}'))?></small></li>
		</ul>
	</div>
	<div class="col-sm-10">
		<h1>Documental <?php echo $model->nombre; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data' => array('documental' => $model, 'contenido' => $contenido),
			'attributes'=>array(
				'documental.nombre',
				array(
					'name' => 'documental.url.slug',
					'type' => 'raw', 
					'value' => l($model->url->slug, bu($model->url->slug), array('target' => '_blank')),
				),
				'contenido.sinopsis:html', 
				'contenido.duracion', 
				'contenido.anio', 
				array(
					'name' => 'documental.background', 
					'type' => 'raw', 
					'value' => l($model->background, bu('images/'.$model->background), array('target' => '_blank', 'class' => 'fancybox')),
				),
				array(
					'name' => 'documental.miniatura', 
					'type' => 'raw', 
					'value' => l($model->miniatura, bu('images/'.$model->miniatura), array('target' => '_blank', 'class' => 'fancybox')),
				),
				'documental.creado',
				'documental.modificado',
				'documental.estado:boolean',
				'documental.destacado:boolean',
			),
		)); ?>
	</div>
</div>
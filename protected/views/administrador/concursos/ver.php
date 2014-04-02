<div class="row">
	<div class="col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li><?php echo l('Volver', bu('administrador/concursos'))?></li>
		  <li><?php echo l('Editar', bu('administrador/concursos/update/' . $model->id))?></li>
		  <li><small><?php echo l('Eliminar', bu('administrador/concursos/delete/' . $model->id), array('onclick' => 'if( !confirm(¿"Seguro que desea borrar la novedad "<?php echo $model->nombre; ?>") ) {return false;}'))?></small></li>
		</ul>
	</div>
	<div class="col-sm-10">
		<h1>Concurso "<?php echo $model->nombre; ?>"</h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data' => array('concurso' => $model, 'contenido' => $contenido),
			'attributes'=>array(
				'concurso.nombre',
				array(
					'name' => 'concurso.url.slug', 
					'type' => 'raw', 
					'value' => l($model->url->slug, bu($model->url->slug), array('target' => '_blank')),
				),
				'contenido.texto:html', 
				array(
					'name' => 'concurso.background', 
					'type' => 'raw', 
					'value' => l($model->background, bu('images/'.$model->background), array('target' => '_blank', 'class' => 'fancybox')),
				),
				array(
					'name' => 'concurso.background_mobile', 
					'type' => 'raw', 
					'value' => l($model->background_mobile, bu('images/'.$model->background_mobile), array('target' => '_blank', 'class' => 'fancybox')),
				),
				array(
					'name' => 'concurso.miniatura', 
					'type' => 'raw', 
					'value' => l($model->miniatura, bu('images/'.$model->miniatura), array('target' => '_blank', 'class' => 'fancybox')),
				),
				'concurso.creado',
				'concurso.modificado',
				'concurso.estado:boolean',
			),
		)); ?>
	</div>
</div>
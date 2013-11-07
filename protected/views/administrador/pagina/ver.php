<div class="row">
	<div class="col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li><?php echo l('Volver', bu('administrador/telemedellin'))?></li>
		  <li><?php echo l('Editar', bu('administrador/telemedellin/update/' . $model->id))?></li>
		  <li><small><?php echo l('Eliminar', bu('administrador/telemedellin/delete/' . $model->id), array('onclick' => 'if( !confirm(¿"Seguro que desea borrar la novedad "<?php echo $model->nombre; ?>") ) {return false;}'))?></small></li>
		</ul>
	</div>
	<div class="col-sm-10">
		<h1>Página <?php echo $model->nombre ?> (<?php echo $model->micrositio->nombre ?>)</h1>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'id',
				'nombre',
				array(
					'name' => 'micrositio.nombre',
					'label' => 'Micrositio',
				), 
				array(
					'name' => 'tipoPagina.nombre',
					'label' => 'Tipo de página',
				), 
				array(
					'name' => 'url.slug', 
					'type' => 'raw', 
					'value' => l($model->url->slug, bu($model->url->slug), array('target' => '_blank')),
				),
				'creado',
				'modificado',
				array(
					'name' => 'estado',
					'value' => (($model->estado==1)?'Si':'No'),
				),
				array(
					'name' => 'destacado',
					'value' => (($model->destacado==1)?'Si':'No'),
				),
			),
		)); ?>
		<h2>Contenido</h2>
		<?php echo $contenido ?>
	</div>
</div>
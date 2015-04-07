<?php $this->pageTitle = 'Video ' . $model->nombre; ?>
<div class="row">
	<div class="col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li><?php echo l('Volver', bu('administrador/videos'))?></li>
		  <li><?php echo l('Editar', bu('administrador/videos/update/' . $model->id))?></li>
		  <li><small><?php echo l('Eliminar', bu('administrador/videos/delete/' . $model->id), array('onclick' => 'if( !confirm(¿"Seguro que desea borrar la novedad "<?php echo $model->nombre; ?>") ) {return false;}'))?></small></li>
		</ul>
	</div>
	<div class="col-sm-10">
		<h1>Video <?php echo $model->nombre; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data' => $model,
			'attributes'=>array(
				'nombre',
				array(
					'name' => 'url.slug',
					'type' => 'raw', 
					'value' => l($model->url->slug, bu($model->albumVideo->micrositio->url->slug . $model->url->slug), array('target' => '_blank')),
				),
				array(
		            'name' => 'albumVideo.nombre', 
		            'label' => 'Álbum'
		        ),
		        array(
		            'name' => 'proveedorVideo.nombre', 
		            'type' => 'raw', 
		            'value' => l($model->proveedorVideo->nombre, $model->url_video, array("target" => "_blank")),
		        ),
		        'descripcion:html',
				'creado',
				'modificado',
				array(
					'name' => 'estado',
					'value' => ($model->estado==1)?'Si':'No',
				),
				'destacado:boolean',
			),
		)); ?>
	</div>
</div>
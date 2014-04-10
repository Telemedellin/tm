<div class="row">
	<div class="col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li><?php echo l('<span class="glyphicon glyphicon-chevron-left"></span> Volver', bu('administrador/especiales'))?></li>
		  <li><?php echo l('<span class="glyphicon glyphicon-pencil"></span> Editar', bu('administrador/especiales/update/' . $model->id))?></li>
		  <li><?php echo l('<small><span class="glyphicon glyphicon-remove"></span> Eliminar</small>', bu('administrador/especiales/delete/' . $model->id), array('onclick' => 'if( !confirm(¿"Seguro que desea borrar la novedad "<?php echo $model->nombre; ?>") ) {return false;}'))?></li>
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
					'name' => 'especial.background_mobile', 
					'type' => 'raw', 
					'value' => l($model->background_mobile, bu('images/'.$model->background_mobile), array('target' => '_blank', 'class' => 'fancybox')),
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
<div class="row">
	<div class="col-sm-12">
	<?php 
	$this->widget('CTabView', array(
	    'tabs'=>array(
	        'tab1'=>array(
	            'title'=>'Fechas',
	            'view'=>'_fechas', 
	            'data'=> array('fechas' => $fechas, 'model' => $model)
	        ),
	        'tab2'=>array(
	            'title'=>'Álbumes de videos',
	            'view'=>'_video', 
	            'data'=> array('videos' => $videos, 'model' => $model)
	        )
	    ),
	));
	?>
	</div>
</div>
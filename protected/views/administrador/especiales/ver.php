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
			'data' => array('especial' => $model),
			'attributes'=>array(
				array(
					'name' => 'especial.nombre',
					'label' => 'Especial',
				),
				array(
					'name' => 'especial.url.slug',
					'type' => 'raw', 
					'value' => l($model->url->slug, bu($model->url->slug), array('target' => '_blank')),
				),
				/*array(
					'name' => 'contenido.resena',
					'label' => 'Reseña',
					'type' => 'html'
				),*/
				array(
					'name' => 'especial.pagina.meta_descripcion',
					'label' => 'Meta descripcion',
				),
				/*array(
					'name' => 'contenido.lugar',
					'label' => 'Lugar',
				),
				array(
					'name' => 'contenido.presentadores',
					'label' => 'Presentadores',
				),*/
				array(
					'name' => 'especial.background', 
					'label' => 'Imagen', 
					'type' => 'raw', 
					'value' => l($model->background, bu('images/'.$model->background), array('target' => '_blank', 'class' => 'fancybox')),
				),
				array(
					'name' => 'especial.background_mobile',
					'label' => 'Imagen (Móviles)',  
					'type' => 'raw', 
					'value' => l($model->background_mobile, bu('images/'.$model->background_mobile), array('target' => '_blank', 'class' => 'fancybox')),
				),
				array(
					'name' => 'especial.miniatura', 
					'label' => 'Imagen miniatura', 
					'type' => 'raw', 
					'value' => l($model->miniatura, bu('images/'.$model->miniatura), array('target' => '_blank', 'class' => 'fancybox')),
				),
				'especial.creado',
				'especial.modificado',
				array(
					'name' => 'especial.estado',
					'label' => 'Estado',
					'type' => 'boolean'
				),
				array(
					'name' => 'especial.destacado',
					'label' => 'Destacado',
					'type' => 'boolean'
				),
			),
		)); ?>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
	<?php 
	$this->widget('CTabView', array(
	    'tabs'=>array(
	        'paginas'=>array(
	            'title'=>'Páginas',
	            'view'=>'_paginas', 
	            'data'=> array('paginas' => $paginas, 'model' => $model)
	        ),
	        'videos'=>array(
	            'title'=>'Álbumes de videos',
	            'view'=>'_video', 
	            'data'=> array('videos' => $videos, 'model' => $model)
	        ), 
	        'fotos'=>array(
	            'title'=>'Álbumes de fotos',
	            'view'=>'_foto', 
	            'data'=> array('fotos' => $fotos, 'model' => $model)
	        ),
	        'menu' => array(
	            'title'=>'Menú',
	            'view'=>'_menu', 
	            'data'=> array('menu' => $menu, 'model' => $model)
	        ), 
	    ),
	));
	?>
	</div>
</div>
<div class="row">
	<div class="col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li><?php echo l('<span class="glyphicon glyphicon-chevron-left"></span> Volver', bu('administrador/telemedellin'))?></li>
		  <li><?php echo l('<span class="glyphicon glyphicon-pencil"></span> Editar', bu('administrador/telemedellin/update/' . $model->id))?></li>
		  <li><?php echo l('<small><span class="glyphicon glyphicon-remove"></span> Eliminar</small>', bu('administrador/telemedellin/delete/' . $model->id), array('onclick' => 'if( !confirm(¿"Seguro que desea borrar la novedad "<?php echo $model->nombre; ?>") ) {return false;}'))?></li>
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
					'name' => 'background_mobile', 
					'type' => 'raw', 
					'value' => l($model->background_mobile, bu('images/'.$model->background_mobile), array('target' => '_blank', 'class' => 'fancybox')),
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
		<?php 
		$tabs_content = array(
	        'paginas'=>array(
	            'title'=>'Páginas',
	            'view'=>'_paginas', 
	            'data'=> array('paginas' => $contenido, 'model' => $model)
	        ), 
	        'menu' => array(
	            'title'=>'Menú',
	            'view'=>'_menu', 
	            'data'=> array('menu' => $menu, 'model' => $model)
	        )
	    );
		$this->widget('CTabView', array('tabs' => $tabs_content));
		?>
	</div>
</div>
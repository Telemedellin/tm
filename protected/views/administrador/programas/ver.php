<div class="row">
	<div class="col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li><?php echo l('Volver', bu('administrador/programas'))?></li>
		  <li><?php echo l('Editar', bu('administrador/programas/update/' . $model->id))?></li>
		  <li><?php echo l('<small>Eliminar</small>', bu('administrador/programas/delete/' . $model->id), array('onclick' => 'if( !confirm(¿"Seguro que desea borrar la novedad "<?php echo $model->nombre; ?>") ) {return false;}'))?></li>
		</ul>
	</div>
	<div class="col-sm-10">
		<h1>Programa <?php echo $model->nombre; ?></h1>
		<?php
		    foreach(Yii::app()->user->getFlashes() as $key => $message) {
		        echo '<div class="flash-' . $key . ' alert alert-info">' . $message . "</div>\n";
		    }
		?>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data' => array('programa' => $model, 'contenido' => $contenido),
			'attributes'=>array(
				'programa.nombre',
				array(
					'name' => 'programa.url.slug',
					'type' => 'raw', 
					'value' => l($model->url->slug, bu($model->url->slug), array('target' => '_blank')),
				),
				'contenido.resena:html', 
				array(
		            'name' => 'contenido.horario',
		            'value' => Horarios::horario_parser($contenido->horario),
		        ),
				array(
					'name' => 'programa.background', 
					'type' => 'raw', 
					'value' => l($model->background, bu('images/'.$model->background), array('target' => '_blank', 'class' => 'fancybox')),
				),
				array(
					'name' => 'programa.miniatura', 
					'type' => 'raw', 
					'value' => l($model->miniatura, bu('images/'.$model->miniatura), array('target' => '_blank', 'class' => 'fancybox')),
				),
				'programa.creado',
				'programa.modificado',
				array(
					'name' => 'contenido.estado',
					'value' => ($contenido->estado==2)?'En emisión':(($contenido->estado==1)?'No se emite':'Desactivado'),
				),
				'programa.destacado:boolean',
			),
		)); ?>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
	<?php 
	$this->widget('CTabView', array(
	    'tabs'=>array(
	        'horarios'=>array(
	            'title'=>'Horarios fijos de emisión',
	            'view'=>'_horario', 
	            'data'=> array('horario' => $horario, 'model' => $model)
	        ),
	        'videos'=>array(
	            'title'=>'Álbumes de videos',
	            'view'=>'_video', 
	            'data'=> array('videos' => $videos, 'model' => $model)
	        ),
	        'redes-sociales'=>array(
	            'title'=>'Redes sociales',
	            'view'=>'_redessociales', 
	            'data'=> array('redes_sociales' => $redes_sociales, 'model' => $model)
	        ),
	        'paginas'=>array(
	            'title'=>'Páginas',
	            'view'=>'_paginas', 
	            'data'=> array('paginas' => $paginas, 'model' => $model)
	        )
	    ),
	));
	?>
	</div>
</div>
<div class="row">
	<div class="col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li><?php echo l('<span class="glyphicon glyphicon-chevron-left"></span> Volver', bu('administrador/albumfoto/view/'. $model->id))?></li>
		  <li><?php echo l('<span class="glyphicon glyphicon-pencil"></span> Editar', bu('administrador/albumfoto/update/' . $model->id))?></li>
		  <li><?php echo l('<small><span class="glyphicon glyphicon-remove"></span> Eliminar</small>', bu('administrador/albumfoto/delete/' . $model->id), array('onclick' => 'if( !confirm(¿"Seguro que desea borrar el album "<?php echo $model->nombre; ?>") ) {return false;}'))?></li>
		</ul>
	</div>
	<div class="col-sm-10">
		<h1>Album de fotos <?php echo $model->nombre; ?> (<?php echo $model->micrositio->nombre ?>)</h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data' => $model,
			'attributes'=>array(
				'nombre',
				array(
					'name' => 'url.slug',
					'type' => 'raw', 
					'value' => l($model->url->slug, bu($model->micrositio->url->slug . $model->url->slug), array('target' => '_blank')),
				),
				'creado',
				'modificado',
				array(
					'name' => 'estado',
					'value' => ($model->estado==1)?'Si':'No',
				),
				'destacado:boolean',
			),
		)); ?>
		<h2>Fotos</h2>
		<!--<p class="pull-right"><?php echo l('Agregar foto', bu('administrador/videos/crear/' . $model->id), array('class' => 'btn btn-default btn-sm'))?></p>-->
		<?php 
		if ($model->galleryBehavior->getGallery() === null) {
		    echo '<p>Before add photos to product gallery, you need to save product</p>';
		} else {
		    $this->widget('ext.galleryManager.GalleryManager', array(
		        'gallery' => $model->galleryBehavior->getGallery(),
		        'controllerRoute' => 'controlGaleria'
		    ));
		}
		?>
	</div>
</div>
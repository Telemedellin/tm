<?php 
$this->pageTitle = 'Álbum Foto "' . $model->nombre . '"'; 
$bc = array();
$bc['Padre'] = Yii::app()->request->urlReferrer;
$bc[] = 'Álbum';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
	<?php $this->renderPartial('//layouts/commons/_flashes'); ?>
	<div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Detalles</h3>
            <div class="box-tools pull-right">
			  <?php if(Yii::app()->user->checkAccess('editar_albumfoto')): ?>
			  <?php echo l('<i class="fa fa-pencil"></i> Editar', $this->createUrl('update', array('id' => $model->id)), array('class' => 'btn btn-primary'))?>
			  <?php endif ?>
			  <?php if(Yii::app()->user->checkAccess('eliminar_albumfoto')): ?>
			  <?php echo l('<small><i class="fa fa-trash-o"></i> Eliminar</small>', $this->createUrl('delete', array('id' => $model->id)), array('onclick' => "if( !window.confirm('¿Seguro que desea borrar el Album Foto \'".$model->nombre."\'?')) {return false;}", 'class' => 'btn btn-danger btn-xs'))?>
			  <?php endif ?>
			</div>
        </div>
        <div class="box-body">
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data' => $model,
			'attributes'=>array(
				'nombre',
				array(
					'name' => 'url.slug',
					'type' => 'raw', 
					'value' => l('<i class="fa fa-external-link"></i> ' .$model->url->slug, bu($model->micrositio->url->slug . $model->url->slug), array('target' => '_blank')),
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

		</div>
	</div>
</div>

<div class="col-sm-12">
	<div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Fotos</h3>
        </div>
    	<div class="box-body">
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
</div>
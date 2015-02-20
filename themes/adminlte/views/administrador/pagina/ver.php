<?php 
$this->pageTitle = 'Página "' . $model->nombre . '"'; 
$bc = array();
$bc['Padre'] = $this->createUrl(lcfirst($model->micrositio->seccion->nombre).'/view', array('id' => $model->micrositio->id));
$bc[] = 'Página';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
	<?php $this->renderPartial('//layouts/commons/_flashes'); ?>
	<div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Detalles</h3>
            <div class="box-tools pull-right">
			  <?php if(Yii::app()->user->checkAccess('editar_paginas')): ?>
			  <?php echo l('<i class="fa fa-pencil"></i> Editar', $this->createUrl('update', array('id' => $model->id)), array('class' => 'btn btn-primary'))?>
			  <?php endif ?>
			  <?php if(Yii::app()->user->checkAccess('eliminar_paginas')): ?>
			  <?php echo l('<small><i class="fa fa-trash-o"></i> Eliminar</small>', $this->createUrl('delete', array('id' => $model->id)), array('onclick' => "if( !window.confirm('¿Seguro que desea borrar la página \'".$model->nombre."\'?')) {return false;}", 'class' => 'btn btn-danger btn-xs'))?>
			  <?php endif ?>
			</div>
        </div>
        <div class="box-body">
			<?php $this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'attributes'=>array(
					'id',
					'nombre',
					'meta_descripcion',
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
						'label' => 'URL',
						'value' => l('<i class="fa fa-external-link"></i> ' .$model->url->slug, bu($model->url->slug), array('target' => '_blank')),
					),
					array(
						'name' => 'background', 
						'label' => 'Imagen', 
						'type' => 'raw', 
						'value' => ($model->background)?l('<i class="fa fa-picture-o"></i> ' . $model->background, bu('images/'.$model->background), array('target' => '_blank', 'class' => 'fancybox')):NULL,
					),
					array(
						'name' => 'background_mobile', 
						'label' => 'Imagen (Móviles)', 
						'type' => 'raw', 
						'value' => ($model->background_mobile)?l('<i class="fa fa-picture-o"></i> ' . $model->background_mobile, bu('images/'.$model->background_mobile), array('target' => '_blank', 'class' => 'fancybox')):NULL,
					),
					array(
						'name' => 'miniatura',
						'label' => 'Imagen miniatura',  
						'type' => 'raw', 
						'value' => ($model->miniatura)?l('<i class="fa fa-picture-o"></i> ' . $model->miniatura, bu('images/'.$model->miniatura), array('target' => '_blank', 'class' => 'fancybox')):NULL,
					),
					'creado',
					'modificado',
					array(
						'name' => 'estado',
						'value' => ($model->estado==2)?'Sí':( ($model->estado==1)?'Archivado':'No' ),
					),
					array(
						'name' => 'destacado',
						'value' => (($model->destacado==1)?'Sí':'No'),
					),
				),
			)); ?>
			<h2>Contenido</h2>
			<?php echo $contenido ?>
		</div>
	</div>
</div>
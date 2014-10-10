<?php 
$this->pageTitle = 'Videos "' . $model->nombre . '"'; 
$bc = array();
$bc['Video'] = bu('/administrador/video');
$bc[] = 'Video';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
	<?php $this->renderPartial('//layouts/commons/_flashes'); ?>
	<div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Detalles</h3>
            <div class="box-tools pull-right">
			  <?php if(Yii::app()->user->checkAccess('editar_video')): ?>
			  <?php echo l('<i class="fa fa-pencil"></i> Editar', bu('administrador/video/update/' . $model->id), array('class' => 'btn btn-primary'))?>
			  <?php endif ?>
			  <?php if(Yii::app()->user->checkAccess('eliminar_video')): ?>
			  <?php echo l('<small><i class="fa fa-trash-o"></i> Eliminar</small>', bu('administrador/video/delete/' . $model->id), array('onclick' => "if( !window.confirm('¿Seguro que desea borrar el video \'".$model->nombre."\'?')) {return false;}", 'class' => 'btn btn-danger btn-xs'))?>
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
						'label' => 'URL',
						'value' => l('<i class="fa fa-external-link"></i> ' .$model->url->slug, bu($model->albumVideo->micrositio->url->slug . $model->url->slug), array('target' => '_blank')),
					),
					array(
			            'name' => 'albumVideo.nombre', 
			            'label' => 'Álbum'
			        ),
			        array(
			            'name' => 'proveedorVideo.nombre', 
			            'type' => 'raw', 
			           	'label' => 'nombre'
			            'value' => l('<i class="fa fa-external-link"></i> ' .$model->proveedorVideo->nombre, $model->url_video, array("target" => "_blank")),
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
</div>
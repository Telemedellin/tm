<?php 
$this->pageTitle = 'Álbum de video"' . $model->nombre . '"'; 
$bc = array();
$bc['Padre'] = Yii::app()->request->urlReferrer;
$bc[] = 'Álbum de video';
$this->breadcrumbs = $bc;
cs()->registerScript(
	'fancybox', 
	'$(".fancybox").fancybox({
		autoSize: false,
		closeBtn: false,
		maxHeight 	: "80%",
		fitToView:false, 
		maxWidth 	: "80%",
		helpers : {
			overlay : {
				closeClick : true,
				css : {
	                "background" : "rgba(0, 0, 0, 0.6)"
	            }
			},
		}
	});',
	CClientScript::POS_READY
);
?>
<div class="col-sm-12">
	<?php $this->renderPartial('//layouts/commons/_flashes'); ?>
	<div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Detalles</h3>
            <div class="box-tools pull-right">
			  <?php if(Yii::app()->user->checkAccess('editar_albumvideo')): ?>
			  <?php echo l('<i class="fa fa-pencil"></i> Editar', $this->createUrl('update', array('id' => $model->id)), array('class' => 'btn btn-primary'))?>
			  <?php endif ?>
			  <?php if(Yii::app()->user->checkAccess('eliminar_albumvideo')): ?>
			  <?php echo l('<small><i class="fa fa-trash-o"></i> Eliminar</small>', $this->createUrl('delete', array('id' => $model->id)), array('onclick' => "if( !window.confirm('¿Seguro que desea borrar el album video \'".$model->nombre."\'?')) {return false;}", 'class' => 'btn btn-danger btn-xs'))?>
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
						'value' =>  l('<i class="fa fa-external-link"></i> ' . $model->url->slug, bu($model->micrositio->url->slug . $model->url->slug), array('target' => '_blank')),
					),
					array(
						'name' => 'thumb', 
						'type' => 'raw', 
						'label' => 'thumb',
						'value' => ($model->thumb)?l('<i class="fa fa-picture-o"></i> ' . $model->thumb, bu('images/'.$model->thumb), array('target' => '_blank', 'class' => 'fancybox')):NULL,
					),
					'creado',
					'modificado',
					array(
						'name' => 'estado',
						'label' => 'estado',
						'value' => ($model->estado==1)?'Sí':'No',
					),
					'destacado:boolean',
				),
			)); ?>
			<?php if(Yii::app()->user->checkAccess('ver_album_videos')): ?>
   			<h2>Videos</h2>
   			<?php $this->renderPartial('/videos/_video', array('model' => $model, 'videos' => $videos)); ?>
   			<?php endif ?>
		</div>
	</div>	
</div>
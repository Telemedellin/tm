<?php 
$this->pageTitle = 'Banner "' . $model->nombre . '"'; 
$bc = array();
$bc['Banners'] = $this->createUrl('banners');
$bc[] = 'Banner';
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
			  <?php if(Yii::app()->user->checkAccess('editar_banner')): ?>
			  <?php echo l('<i class="fa fa-pencil"></i> Editar', $this->createUrl('updatebanner', array('id' => $model->id)), array('class' => 'btn btn-primary'))?>
			  <?php endif ?>
			  <?php if(Yii::app()->user->checkAccess('eliminar_banner')): ?>
			  <?php echo l('<small><i class="fa fa-trash-o"></i> Eliminar</small>', $this->createUrl('deletebanner', array('id' => $model->id)), array('onclick' => "if( !window.confirm('¿Seguro que desea borrar el banner \'".$model->nombre."\'?')) {return false;}", 'class' => 'btn btn-danger btn-xs'))?>
			  <?php endif ?>
			</div>
        </div>
        <div class="box-body">
			<?php $this->widget('zii.widgets.CDetailView', array(
				'data' => $model,
				'attributes'=>array(
					'nombre', 
					array(
			            'name' => 'url', 
			            'type' => 'raw', 
			            'label' => 'URL',
			            'value' => l('<i class="fa fa-external-link"></i> ' .$model->url, $model->url, array("target" => "_blank")), 
			        ),
			        array(
						'name' => 'imagen', 
						'label' => 'Imagen', 
						'type' => 'raw', 
						'value' => ($model->imagen)?l('<i class="fa fa-picture-o"></i> ' . $model->imagen, bu('images/'.$model->imagen), array('target' => '_blank', 'class' => 'fancybox')):NULL,
					),
					array(
						'name' => 'imagen_mobile', 
						'label' => 'Imagen (Móviles)', 
						'type' => 'raw', 
						'value' => ($model->imagen_mobile)?l('<i class="fa fa-picture-o"></i> ' . $model->imagen_mobile, bu('images/'.$model->imagen_mobile), array('target' => '_blank', 'class' => 'fancybox')):NULL,
					),
			        'creado',
					'modificado',
					array(
						'name' => 'contador',
						'value' => ($model->contador==1)?'Activado':'Desactivado',
					),
					'fin_contador',
					'inicio_publicacion',
					'fin_publicacion',
					array(
						'name' => 'estado',
						'value' => ($model->estado==1)?'Sí':'No',
					),
				),
			)); ?>
		</div>
	</div>
</div>
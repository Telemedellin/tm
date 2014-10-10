<?php 
$this->pageTitle = 'Guiño "' . $model->nombre . '"'; 
$bc = array();
$bc['Guiños'] = bu('/administrador/guino');
$bc[] = 'Guiño';
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
				<?php if(Yii::app()->user->checkAccess('editar_guinos')): ?>
				<?php echo l('<i class="fa fa-pencil"></i> Editar', bu('administrador/guino/update/' . $model->id), array('class' => 'btn btn-primary'))?>
		  		<?php endif ?>
		  		<?php if(Yii::app()->user->checkAccess('eliminar_guinos')): ?>
		  		<?php echo l('<small><i class="fa fa-trash-o"></i> Eliminar</small>', bu('administrador/guino/delete/' . $model->id), array('onclick' => "if( !window.confirm('¿Seguro que desea borrar el guiño \'".$model->nombre."\'?')) {return false;}", 'class' => 'btn btn-danger btn-xs'))?>
		  		<?php endif ?>	
			</div>
        </div>
        <div class="box-body">
			<?php $this->widget('zii.widgets.CDetailView', array(
				'data' => $model,
				'attributes'=>array(
					'nombre', 
					array(
						'name' => 'guino', 
						'label' => 'Imagen', 
						'type' => 'raw', 
						'value' => ($model->guino)?l('<i class="fa fa-picture-o"></i> ' . $model->guino, bu('images/'.$model->guino), array('target' => '_blank', 'class' => 'fancybox')):NULL,
					),
					array(
						'name' => 'guino_mobile', 
						'label' => 'Guiño (Móviles)', 
						'type' => 'raw', 
						'value' => ($model->guino_mobile)?l('<i class="fa fa-picture-o"></i> ' . $model->guino_mobile, bu('images/'.$model->guino_mobile), array('target' => '_blank', 'class' => 'fancybox')):NULL,
					),
			        'creado',
					'modificado',
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
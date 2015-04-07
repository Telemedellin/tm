<?php 
$this->pageTitle = 'Novedad "' . $model->nombre . '"'; 
$bc = array();
$bc['Novedades'] = $this->createUrl('index');
$bc[] = 'Novedad';
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
			  <?php if(Yii::app()->user->checkAccess('editar_novedades')): ?>
			  <?php echo l('<i class="fa fa-pencil"></i> Editar', $this->createUrl('update', array('id' => $model->id)), array('class' => 'btn btn-primary'))?>
			  <?php endif ?>
			  <?php if(Yii::app()->user->checkAccess('eliminar_novedades')): ?>
			  <?php echo l('<small><i class="fa fa-trash-o"></i> Eliminar</small>', $this->createUrl('delete', array('id' => $model->id)), array('onclick' => "if( !window.confirm('¿Seguro que desea borrar la novedad \'".$model->nombre."\'?')) {return false;}", 'class' => 'btn btn-danger btn-xs'))?>
			  <?php endif ?>
			</div>
        </div>
  		<div class="box-body">
			<?php $this->widget('zii.widgets.CDetailView', array(
				'data' => $model,
				'attributes'=>array(
					'id',
					'nombre',
					array(
						'name' => 'url.slug', 
						'label' => 'URL',
						'type' => 'raw', 
						'value' => l('<i class="fa fa-external-link"></i> ' .$model->url->slug, bu($model->url->slug), array('target' => '_blank')),
					),
					'pgArticuloBlogs.entradilla:html',
					'pgArticuloBlogs.texto:html',
					array(
						'name' => 'pgArticuloBlogs.enlace', 
						'type' => 'raw', 
						'label' => 'Enlace',
						'value' => ($model->pgArticuloBlogs->enlace)?l('<i class="fa fa-external-link"></i> ' .$model->pgArticuloBlogs->enlace, $model->pgArticuloBlogs->enlace, array('target' => '_blank')):NULL,
					),
					array(
						'name' => 'background', 
						'type' => 'raw', 
						'label' => 'Imagen',
						'value' =>  ($model->background)?l('<i class="fa fa-picture-o"></i> ' . $model->background, bu('images/'.$model->background), array('target' => '_blank', 'class' => 'fancybox')):NULL,
					),
					array(
						'name' => 'background_mobile', 
						'type' => 'raw', 
						'label' => 'Imagen móvil',
						'value' =>  ($model->background_mobile)?l('<i class="fa fa-picture-o"></i> ' . $model->background_mobile, bu('images/'.$model->background_mobile), array('target' => '_blank', 'class' => 'fancybox')):NULL,
					),
					array(
						'name' => 'miniatura', 
						'type' => 'raw', 
						'label' => 'Miniatura',
						'value' => ($model->miniatura)?l('<i class="fa fa-picture-o"></i> ' . $model->miniatura, bu('images/'.$model->miniatura), array('target' => '_blank', 'class' => 'fancybox')):NULL,
					),
					'creado',
					'modificado',
					array(
						'name' => 'pgArticuloBlogs.posicion', 
						'type' => 'raw', 
						'label' => 'posicion',
						'value' => ($model->pgArticuloBlogs->posicion==1)?'Arriba':'Abajo',
					),
					array(
						'name' => 'estado',
						'label' => 'Estado', 
						'value' => ($model->estado==2)?'Publicado (en el home)':(($model->estado==1)?'Archivado':'Desactivado'),
					),
					'destacado:boolean'
				),
			)); ?>
		</div>
	</div>
</div>
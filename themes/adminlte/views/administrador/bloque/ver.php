<?php 
$this->pageTitle = 'Bloque "' . $model->nombre . '"'; 
$bc = array();
$bc['Padre'] = bu('/administrador/pagina/view/'.$model->pgBloques->pagina->id);
$bc[] = 'Bloque';
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
			  <?php if(Yii::app()->user->checkAccess('editar_bloque')): ?>
			  <?php echo l('<i class="fa fa-pencil"></i> Editar', bu('administrador/bloque/update/' . $model->id), array('class' => 'btn btn-primary'))?>
			  <?php endif ?>
			  <?php if(Yii::app()->user->checkAccess('eliminar_especial')): ?>
			  <?php echo l('<small><i class="fa fa-trash-o"></i> Eliminar</small>', bu('administrador/bloque/delete/' . $model->id), array('onclick' => "if( !window.confirm('¿Seguro que desea borrar el programa \'".$model->nombre."\'?')) {return false;}", 'class' => 'btn btn-danger btn-xs'))?>
			  <?php endif ?>
			</div>
        </div>
        <div class="box-body">
		<h1>Bloque "<?php echo $model->nombre; ?>"</h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data' => array('concurso' => $model, 'contenido' => $contenido),
			'attributes'=>array(
				array(
					'name' => 'concurso.nombre',
					'label' => 'Concurso',
				),
				array(
					'name' => 'concurso.url.slug', 
					'label' => 'URL',
					'type' => 'raw', 
					'value' => l('<i class="fa fa-external-link"></i> ' .$model->url->slug, bu($model->url->slug), array('target' => '_blank')),
				),
				array(
					'name' => 'contenido.texto',
					'label' => 'Texto',
					'type' => 'html',
				),
				array(
					'name' => 'concurso.pagina.meta_descripcion',
					'label' => 'Meta descripción',
				),
				array(
					'name' => 'concurso.background', 
					'label' => 'Imagen', 
					'type' => 'raw', 
					'value' => ($model->background)?l('<i class="fa fa-picture-o"></i> ' . $model->background, bu('images/'.$model->background), array('target' => '_blank', 'class' => 'fancybox')):NULL,
				),
				array(
					'name' => 'concurso.background_mobile', 
					'label' => 'Imagen (Móviles)', 
					'type' => 'raw', 
					'value' => ($model->background_mobile)?l('<i class="fa fa-picture-o"></i> ' . $model->background, bu('images/'.$model->background), array('target' => '_blank', 'class' => 'fancybox')):NULL,
				),
				array(
					'name' => 'concurso.miniatura', 
					'label' => 'Imagen miniatura', 
					'type' => 'raw', 
					'value' => l($model->miniatura, bu('images/'.$model->miniatura), array('target' => '_blank', 'class' => 'fancybox')),
				),
				'concurso.creado',
				'concurso.modificado',
				array(
					'name' => 'contenido.estado',
					'label' => 'Publicado',
					'type' => 'boolean',
				),
			),
		)); ?>
	</div>
</div>
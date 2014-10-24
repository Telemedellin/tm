<?php 
$this->pageTitle = 'Programa "' . $model->nombre . '"'; 
$bc = array();
$bc['Programas'] = $this->createUrl('index');
$bc[] = 'Programa';
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
			  <?php if(Yii::app()->user->checkAccess('editar_programas')): ?>
			  <?php echo l('<i class="fa fa-pencil"></i> Editar', $this->createUrl('update', array('id' => $model->id)), array('class' => 'btn btn-primary'));?>
			  <?php endif ?>
			  <?php if(Yii::app()->user->checkAccess('eliminar_programas')): ?>
			  <?php echo l('<small><i class="fa fa-trash-o"></i> Eliminar</small>', $this->createUrl('delete', array('id' => $model->id)), array('onclick' => "if( !window.confirm('¿Seguro que desea borrar el programa \'".$model->nombre."\'?')) {return false;}", 'class' => 'btn btn-danger btn-xs'))?>
			  <?php endif ?>
			</div>
        </div>
        <div class="box-body">
			<?php $this->widget('zii.widgets.CDetailView', array(
				'data' => array('programa' => $model, 'contenido' => $contenido),
				'attributes'=>array(
					'id',
					array(
						'name' => 'programa.nombre',
						'label' => 'Programa',
					),
					array(
						'name' => 'programa.url.slug',
						'label' => 'URL',
						'type' => 'raw', 
						'value' => l('<i class="fa fa-external-link"></i> ' . $model->url->slug, bu($model->url->slug), array('target' => '_blank')),
					),
					array(
						'name' =>'contenido.resena', 
						'label' => 'Reseña',
						'type' => 'html', 
					),	
					array(
						'name' =>'programa.pagina.meta_descripcion', 
						'label' => 'Meta descripción',
					),				
					array(
			            'name' => 'contenido.horario',
			            'label' => 'Horario', 
			            'type' => 'raw', 
			            'value' => Horarios::horario_parser($contenido->horario),
			        ),
					array(
						'name' => 'programa.background', 
						'label' => 'Imagen', 
						'type' => 'raw', 
						'value' => ($model->background)?l('<i class="fa fa-picture-o"></i> ' . $model->background, bu('images/'.$model->background), array('target' => '_blank', 'class' => 'fancybox')):NULL,
					),
					array(
						'name' => 'programa.background_mobile', 
						'label' => 'Imagen (Móviles)', 
						'type' => 'raw', 
						'value' => ($model->background_mobile)?l('<i class="fa fa-picture-o"></i> ' . $model->background_mobile, bu('images/'.$model->background_mobile), array('target' => '_blank', 'class' => 'fancybox')):NULL,
					),
					array(
						'name' => 'programa.miniatura',
						'label' => 'Imagen miniatura',  
						'type' => 'raw', 
						'value' => ($model->miniatura)?l('<i class="fa fa-picture-o"></i> ' . $model->miniatura, bu('images/'.$model->miniatura), array('target' => '_blank', 'class' => 'fancybox')):NULL,
					),
					'programa.creado',
					'programa.modificado',
					array(
						'name' => 'contenido.estado',
						'label' => 'Estado', 
						'value' => ($contenido->estado==2)?'En emisión':(($contenido->estado==1)?'No se emite':'Desactivado'),
					),
					array(
						'name' =>'programa.destacado', 
						'label' => 'Destacado',
						'type' => 'boolean', 
					),
				),
			)); ?>
		</div>
	</div>
</div>
<?php 
if( Yii::app()->user->checkAccess('ver_paginas') )
{
	$tabs_content['paginas'] = 
		array(
            'title'=>'Páginas',
            'view'=>'/pagina/_paginas', 
            'data'=> array('paginas' => $paginas, 'model' => $model)
        );
}
if( Yii::app()->user->checkAccess('ver_menus') || Yii::app()->user->checkAccess('ver_menu_item') )
{
    $tabs_content['menu'] =    
        array(
            'title'=>'Menú',
            'view'=>'/menu/_menu', 
            'data'=> array('menu' => $menu, 'model' => $model)
        );
}
if( Yii::app()->user->checkAccess('ver_album_fotos') )
{
    $tabs_content['fotos'] =    
        array(
            'title'=>'Álbumes de fotos',
            'view'=>'/albumfoto/_foto', 
            'data'=> array('fotos' => $fotos, 'model' => $model)
        );
}
if( Yii::app()->user->checkAccess('ver_album_videos') )
{
	$tabs_content['videos'] = 
		array(
            'title'=>'Álbumes de videos',
            'view'=>'/albumvideo/_video', 
            'data'=> array('videos' => $videos, 'model' => $model)
        );
}
if( Yii::app()->user->checkAccess('ver_horarios') )
{
	$tabs_content['horarios'] = 
		array(
            'title'=>'Horarios fijos de emisión',
            'view'=>'/horario/_horario', 
            'data'=> array('horario' => $horario, 'model' => $model)
        );
}
if( Yii::app()->user->checkAccess('ver_redes_sociales') )
{
	$tabs_content['redes-sociales'] = 
		array(
            'title'=>'Redes sociales',
            'view'=>'/redsocial/_redessociales', 
            'data'=> array('redes_sociales' => $redes_sociales, 'model' => $model)
        );
}
?>
<div class="col-sm-12">
	<div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Contenido adicional</h3>
        </div>
    	<div class="box-body">
    		<?php if( isset($tabs_content) ) $this->widget('application.components.MyTabView', array('tabs' => $tabs_content));?>
    	</div>
    </div>
</div>
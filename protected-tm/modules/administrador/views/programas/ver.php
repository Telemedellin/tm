<?php $this->pageTitle = 'Programa ' . $model->nombre; ?>
<div class="row">
	<div class="col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li><?php echo l('<span class="glyphicon glyphicon-chevron-left"></span> Volver', bu('administrador/programas'))?></li>
		  <?php if(Yii::app()->user->checkAccess('editar_programas')): ?>
		  <li><?php echo l('<span class="glyphicon glyphicon-pencil"></span> Editar', bu('administrador/programas/update/' . $model->id))?></li>
		  <?php endif ?>
		  <?php if(Yii::app()->user->checkAccess('eliminar_programas')): ?>
		  <li><?php echo l('<small><span class="glyphicon glyphicon-remove"></span> Eliminar</small>', bu('administrador/programas/delete/' . $model->id), array('onclick' => 'if( !confirm(¿"Seguro que desea borrar la novedad "<?php echo $model->nombre; ?>") ) {return false;}'))?></li>
		  <?php endif ?>
		</ul>
	</div>
	<div class="col-sm-10">
		<h1>Programa <?php echo $model->nombre; ?></h1>
		<?php
		    foreach(Yii::app()->user->getFlashes() as $key => $message) {
		        echo '<div class="flash-' . $key . ' alert alert-info">' . $message . "</div>\n";
		    }
		?>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data' => array('programa' => $model, 'contenido' => $contenido),
			'attributes'=>array(
				array(
					'name' => 'programa.nombre',
					'label' => 'Programa',
				),
				array(
					'name' => 'programa.url.slug',
					'label' => 'URL',
					'type' => 'raw', 
					'value' => l($model->url->slug, bu($model->url->slug), array('target' => '_blank')),
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
					'value' => l($model->background, bu('images/'.$model->background), array('target' => '_blank', 'class' => 'fancybox')),
				),
				array(
					'name' => 'programa.background_mobile', 
					'label' => 'Imagen (Móviles)', 
					'type' => 'raw', 
					'value' => l($model->background_mobile, bu('images/'.$model->background_mobile), array('target' => '_blank', 'class' => 'fancybox')),
				),
				array(
					'name' => 'programa.miniatura',
					'label' => 'Imagen miniatura',  
					'type' => 'raw', 
					'value' => l($model->miniatura, bu('images/'.$model->miniatura), array('target' => '_blank', 'class' => 'fancybox')),
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
<div class="row">
	<div class="col-sm-12">
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
	if( isset($tabs_content) ) $this->widget('CTabView', array('tabs' => $tabs_content));
	?>
	</div>
</div>
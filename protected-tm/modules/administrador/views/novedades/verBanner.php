<?php $this->pageTitle = 'Banner ' . $model->nombre; ?>
<div class="row">
	<div class="col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li><?php echo l('<span class="glyphicon glyphicon-chevron-left"></span> Volver', bu('administrador/novedades/banners'))?></li>
		  <?php if(Yii::app()->user->checkAccess('editar_banners')): ?>
		  <li><?php echo l('<span class="glyphicon glyphicon-pencil"></span> Editar', bu('administrador/novedades/updatebanner/' . $model->id))?></li>
		  <?php endif ?>
		  <?php if(Yii::app()->user->checkAccess('eliminar_banners')): ?>
		  <li><?php echo l('<small><span class="glyphicon glyphicon-remove"></span> Eliminar</small>', bu('administrador/novedades/deletebanner/' . $model->id), array('onclick' => 'if( !confirm(¿"Seguro que desea borrar el item "<?php echo $model->nombre; ?>") ) {return false;}'))?></li>
		  <?php endif ?>
		</ul>
	</div>
	<div class="col-sm-10">
		<h1>Item <?php echo $model->nombre; ?></h1>
		<?php
		    foreach(Yii::app()->user->getFlashes() as $key => $message) {
		        echo '<div class="flash-' . $key . ' alert alert-info">' . $message . "</div>\n";
		    }
		?>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data' => $model,
			'attributes'=>array(
				'nombre', 
				array(
		            'name' => 'url', 
		            'type' => 'raw', 
		            'value' => l($model->url, $model->url, array("target" => "_blank")), 
		        ),
		        array(
					'name' => 'imagen', 
					'label' => 'Imagen', 
					'type' => 'raw', 
					'value' => l($model->imagen, bu('images/novedades/banners/'.$model->imagen), array('target' => '_blank', 'class' => 'fancybox')),
				),
				array(
					'name' => 'imagen_mobile', 
					'label' => 'Imagen (Móviles)', 
					'type' => 'raw', 
					'value' => l($model->imagen_mobile, bu('images/novedades/banners/'.$model->imagen_mobile), array('target' => '_blank', 'class' => 'fancybox')),
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
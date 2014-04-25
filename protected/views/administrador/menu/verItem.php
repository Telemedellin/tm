<div class="row">
	<div class="col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li><?php echo l('<span class="glyphicon glyphicon-chevron-left"></span> Volver', bu('administrador/menu'))?></li>
		  <li><?php echo l('<span class="glyphicon glyphicon-pencil"></span> Editar', bu('administrador/menu/updateitem/' . $model->id))?></li>
		  <li><?php echo l('<small><span class="glyphicon glyphicon-remove"></span> Eliminar</small>', bu('administrador/menuitem/delete/' . $model->id), array('onclick' => 'if( !confirm(¿"Seguro que desea borrar el item "<?php echo $model->label; ?>") ) {return false;}'))?></li>
		</ul>
	</div>
	<div class="col-sm-10">
		<h1>Item <?php echo $model->label; ?></h1>
		<?php
		    foreach(Yii::app()->user->getFlashes() as $key => $message) {
		        echo '<div class="flash-' . $key . ' alert alert-info">' . $message . "</div>\n";
		    }
		?>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data' => $model,
			'attributes'=>array(
				'label', 
				array(
					'name' => 'menu.nombre', 
					'label' => 'Menú', 
				),
				'tipoLink.nombre', 
				array(
		            'name' => 'url_id', 
		            'type' => 'html', 
		            'value' => 'l($data->urlx->slug, bu($data->urlx->slug), array("target" => "_blank"))', 
		        ),
		        'orden', 
				'creado',
				'modificado',
				array(
					'name' => 'estado',
					'value' => ($model->estado==1)?'Sí':'No',
				),
			),
		)); ?>
	</div>
</div>
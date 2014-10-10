<?php $this->pageTitle = 'Guiño ' . $model->nombre; ?>
<div class="row">
	<div class="col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li><?php echo l('<span class="glyphicon glyphicon-chevron-left"></span> Volver', bu('administrador/guino'))?></li>
		  <?php if(Yii::app()->user->checkAccess('editarguinos')): ?>
		  <li><?php echo l('<span class="glyphicon glyphicon-pencil"></span> Editar', bu('administrador/guino/update/' . $model->id))?></li>
		  <?php endif ?>
		  <?php if(Yii::app()->user->checkAccess('eliminarguinos')): ?>
		  <li><?php echo l('<small><span class="glyphicon glyphicon-remove"></span> Eliminar</small>', bu('administrador/guino/delete/' . $model->id), array('onclick' => 'if( !confirm(¿"Seguro que desea borrar el guiño "<?php echo $model->nombre; ?>") ) {return false;}'))?></li>
		  <?php endif ?>
		</ul>
	</div>
	<div class="col-sm-10">
		<h1>Guiño <?php echo $model->nombre; ?></h1>
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
					'name' => 'guino', 
					'label' => 'Imagen', 
					'type' => 'raw', 
					'value' => l($model->guino, bu('images/guinos/'.$model->guino), array('target' => '_blank', 'class' => 'fancybox')),
				),
				array(
					'name' => 'guino_mobile', 
					'label' => 'Guiño (Móviles)', 
					'type' => 'raw', 
					'value' => l($model->guino_mobile, bu('images/guinos/'.$model->guino_mobile), array('target' => '_blank', 'class' => 'fancybox')),
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
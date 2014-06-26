<?php $this->pageTitle = 'Página ' . $model->nombre; ?>
<div class="row">
	<div class="col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li><?php echo l('<span class="glyphicon glyphicon-chevron-left"></span> Volver', Yii::app()->request->urlReferrer)?></li>
		  <?php if(Yii::app()->user->checkAccess('editar_paginas')): ?>
		  <li><?php echo l('<span class="glyphicon glyphicon-pencil"></span> Editar', bu('administrador/pagina/update/' . $model->id))?></li>
		  <?php endif ?>
		  <?php if(Yii::app()->user->checkAccess('eliminar_paginas')): ?>
		  <li><?php echo l('<small><span class="glyphicon glyphicon-remove"></span> Eliminar</small>', bu('administrador/pagina/delete/' . $model->id), array('onclick' => 'if( !confirm(¿"Seguro que desea borrar la novedad "<?php echo $model->nombre; ?>") ) {return false;}'))?></li>
		  <?php endif ?>
		</ul>
	</div>
	<div class="col-sm-10">
		<h1>Página <?php echo $model->nombre ?> (<?php echo $model->micrositio->nombre ?>)</h1>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'id',
				'nombre',
				'meta_descripcion',
				array(
					'name' => 'micrositio.nombre',
					'label' => 'Micrositio',
				), 
				array(
					'name' => 'tipoPagina.nombre',
					'label' => 'Tipo de página',
				), 
				array(
					'name' => 'url.slug', 
					'type' => 'raw', 
					'value' => l($model->url->slug, bu($model->url->slug), array('target' => '_blank')),
				),
				'creado',
				'modificado',
				array(
					'name' => 'estado',
					'value' => ($model->estado==2)?'Sí':( ($model->estado==1)?'Archivado':'No' ),
				),
				array(
					'name' => 'destacado',
					'value' => (($model->destacado==1)?'Si':'No'),
				),
			),
		)); ?>
		<h2>Contenido</h2>
		<?php echo $contenido ?>
	</div>
</div>
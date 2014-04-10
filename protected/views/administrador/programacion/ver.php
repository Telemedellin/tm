<div class="row">
	<div class="col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li><?php echo l('<span class="glyphicon glyphicon-chevron-left"></span> Volver', bu('administrador/programacion'))?></li>
		  <li><?php echo l('<span class="glyphicon glyphicon-pencil"></span> Editar', bu('administrador/programacion/update/' . $model->id))?></li>
		  <li><?php echo l('<small><span class="glyphicon glyphicon-remove"></span> Eliminar</small>', bu('administrador/programacion/delete/' . $model->id), array('onclick' => 'if( !confirm(¿"Seguro que desea borrar la novedad "<?php echo $model->nombre; ?>") ) {return false;}'))?></li>
		</ul>
	</div>
	<div class="col-sm-10">
		<h1>Programación</h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data' => $model,
			'attributes'=>array(
				'id',
				'micrositio.nombre',
				array(
		            'name'=>'hora_inicio',
		            'type'=>'time',
		            'value'=>$model->hora_inicio,
		        ),
		        array(
		            'name'=>'hora_fin',
		            'type'=>'time',
		            'value'=>$model->hora_fin,
		        ),
				'estado:boolean',
			),
		)); ?>
	</div>
</div>

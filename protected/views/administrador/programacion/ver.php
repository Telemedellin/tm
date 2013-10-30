<div class="row">
	<div class="col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li><?php echo l('Volver', bu('administrador/programacion'))?></li>
		  <li><?php echo l('Editar', bu('administrador/programacion/update/' . $model->id))?></li>
		  <li><small><?php echo l('Eliminar', bu('administrador/programacion/delete/' . $model->id), array('onclick' => 'if( !confirm(¿"Seguro que desea borrar la novedad "<?php echo $model->nombre; ?>") ) {return false;}'))?></small></li>
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

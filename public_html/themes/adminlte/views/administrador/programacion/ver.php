<?php 
$this->pageTitle = 'Programacion "' . $model->micrositio->nombre . ' - ' . $model->hora_inicio.'"'; 
$bc = array();
$bc['Programación'] = $this->createUrl('index');
$bc[] = 'Programa';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
	<?php $this->renderPartial('//layouts/commons/_flashes'); ?>
	<div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Detalles</h3>
            <div class="box-tools pull-right">
			  <?php if(Yii::app()->user->checkAccess('editar_programacion')): ?>
			  <?php echo l('<i class="fa fa-pencil"></i> Editar', $this->createUrl('update', array('id' => $model->id)), array('class' => 'btn btn-primary'))?>
			  <?php endif ?>
			  <?php if(Yii::app()->user->checkAccess('eliminar_programacion')): ?>
			  <?php echo l('<small><i class="fa fa-trash-o"></i> Eliminar</small>', $this->createUrl('delete', array('id' => $model->id)), array('onclick' => "if( !window.confirm('¿Seguro que desea borrar la programación \'". $model->micrositio->nombre . " - " . $model->hora_inicio."\'?')) {return false;}", 'class' => 'btn btn-danger btn-xs'))?>
			  <?php endif ?>
			</div>
        </div>
        <div class="box-body">
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
</div>

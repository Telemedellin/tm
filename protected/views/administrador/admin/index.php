<?php $this->pageTitle=Yii::app()->name; ?>
<p>Bienvenido al administrador, utilice el menú para acceder a las opciones de configuración.</p>
<div class="row">
	<div class="col-sm-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Programación de hoy <?php echo l( '<span class="glyphicon glyphicon-plus"></span>', bu('administrador/programacion/crear'), array('class' => 'pull-right', 'title' => 'Agregar a la parrilla') ); ?></h3>
			</div>
			<div class="panel-body">
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'dataProvider'=>$programacion,
					'enableSorting' => true,
					'summaryText'=>'',  
					'columns'=>array(
				        'micrositio.nombre',
				         array(
				            'name'=>'hora_inicio',
				            'value'=>'date("H:i", $data->hora_inicio)',
				        ),
				        array(
				            'name'=>'hora_fin',
				            'value'=>'date("H:i", $data->hora_fin)',
				        ),
				        array(
				            'class'=>'CButtonColumn',
				            'template' => '{view} {update}',
				            'viewButtonUrl' => 'Yii::app()->createUrl("/administrador/programacion/view", array("id"=>$data->id))',
				            'updateButtonUrl' => 'Yii::app()->createUrl("/administrador/programacion/update", array("id"=>$data->id))',
				        ),
				    )
				)); ?>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Novedades en el home <?php echo l( '<span class="glyphicon glyphicon-plus"></span>', bu('administrador/novedades/crear'), array('class' => 'pull-right', 'title' => 'Agregar novedad') ); ?></h3>
			</div>
			<div class="panel-body">
				<?php $this->widget('zii.widgets.grid.CGridView', array(
				'dataProvider'=>$novedades,
				'enableSorting' => true,
				'enablePagination' => false,
				'summaryText'=>'',  
			    //'rowCssClassExpression' => '($data->destacado=="1")?"alert-success":(($data->estado=="2")?"alert-primary":(($data->estado=="1")?"alert-warning":"alert-danger"))',
				'columns'=>array(
			        array(
			            'name'=>'nombre',
			            'header'=>'Nombre',
			            'type' => 'raw', 
			            'value'=>'"<strong>".$data->nombre."</strong>"'
			        ),
			        array(
			            'name'=>'destacado',
			            'filter'=>array('1'=>'Si','0'=>'No'),
			            'value'=>'($data->destacado=="1")?("Si"):("No")'
			        ),
			        array(
			            'class'=>'CButtonColumn',
			            'template' => '{view} {update}',
			            'viewButtonUrl' => 'Yii::app()->createUrl("/administrador/novedades/view", array("id"=>$data->id))',
			            'updateButtonUrl' => 'Yii::app()->createUrl("/administrador/novedades/update", array("id"=>$data->id))',
			        ),
			    )
			)); ?>
			</div>
		</div>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Concursos publicados <?php echo l( '<span class="glyphicon glyphicon-plus"></span>', bu('administrador/concursos/crear'), array('class' => 'pull-right', 'title' => 'Agregar concurso') ); ?></h3>
			</div>
			<div class="panel-body">
				<?php $this->widget('zii.widgets.grid.CGridView', array(
				'dataProvider'=>$concursos,
				'enableSorting' => true,
				'enablePagination' => false,
				'summaryText'=>'',  
				'columns'=>array(
			        'nombre',
			        array(
			            'class'=>'CButtonColumn',
			            'template' => '{view} {update}',
			            'viewButtonUrl' => 'Yii::app()->createUrl("/administrador/concursos/view", array("id"=>$data->id))',
			            'updateButtonUrl' => 'Yii::app()->createUrl("/administrador/concursos/update", array("id"=>$data->id))',
			        ),
			    )
			)); ?>
			</div>
		</div>
		
	</div>
</div>
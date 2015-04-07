<?php $this->pageTitle = 'Administrador ' . Yii::app()->name; ?>
<p>Bienvenido al administrador, utilice el menú para acceder a las opciones de configuración.</p>
<div class="paneles">
<!--<div class="row">-->
	<!--<div class="col-sm-6">-->
		<?php if(Yii::app()->user->checkAccess('ver_programacion')): ?>
		<div class="pull-left">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><span class="glyphicon glyphicon-calendar"></span> Programación de hoy <?php echo (Yii::app()->user->checkAccess('crear_programacion')) ? l( '<span class="glyphicon glyphicon-plus"></span>', bu('administrador/programacion/crear'), array('class' => 'pull-right', 'title' => 'Agregar a la parrilla') ):''; ?></h3>
			</div>
			<div class="panel-body">
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'dataProvider'=>$programacion,
					'summaryText'=>'',  
					'columns'=>array(
				        'micrositio.nombre',
				         array(
				            'header' => 'Empieza',
				            'name'=>'hora_inicio',
				            'value'=>'date("H:i", $data->hora_inicio)',
				        ),
				        array(
				            'header' => 'Termina',
				            'name'=>'hora_fin',
				            'value'=>'date("H:i", $data->hora_fin)',
				        ),
				        array(
				            'class'=>'CButtonColumn',
				            'template' => '{view} {update}',
				            'viewButtonUrl' => 'Yii::app()->createUrl("/administrador/programacion/view", array("id"=>$data->id))',
				            'buttons' => array(
				            	'update' => array(
				            		'url' => 'Yii::app()->createUrl("/administrador/programacion/update", array("id"=>$data->id))', 
				            		'visible' => '(Yii::app()->user->checkAccess("editar_programacion"))?true:false', 
				            	),
				            ),
				        ),
				    )
				)); ?>
			</div>
		</div>
		</div>
		<?php endif ?>
	<!--</div>-->
	<!--<div class="col-sm-6">-->
		<?php if(Yii::app()->user->checkAccess('ver_novedades')): ?>
		<div class="pull-left">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><span class="glyphicon glyphicon-bullhorn"></span> Novedades en el home <?php echo (Yii::app()->user->checkAccess('crear_novedades')) ? l( '<span class="glyphicon glyphicon-plus"></span>', bu('administrador/novedades/crear'), array('class' => 'pull-right', 'title' => 'Agregar novedad') ):''; ?></h3>
			</div>
			<div class="panel-body">
				<?php $this->widget('zii.widgets.grid.CGridView', array(
				'dataProvider'=>$novedades->search(),
				'enablePagination' => false,
				'summaryText'=>'',  
			    //'rowCssClassExpression' => '($data->destacado=="1")?"alert-success":(($data->estado=="2")?"alert-primary":(($data->estado=="1")?"alert-warning":"alert-danger"))',
				'columns'=>array(
			        'nombre', 
			        array(
			            'name'=>'destacado',
			            'filter'=>array('1'=>'Si','0'=>'No'),
			            'value'=>'($data->destacado=="1")?("Si"):("No")'
			        ),
			        array(
			            'class'=>'CButtonColumn',
			            'template' => '{view} {update}',
			            'viewButtonUrl' => 'Yii::app()->createUrl("/administrador/novedades/view", array("id"=>$data->id))',
			            'buttons' => array(
			            	'update' => array(
			            		'url' => 'Yii::app()->createUrl("/administrador/novedades/update", array("id"=>$data->id))', 
			            		'visible' => '(Yii::app()->user->checkAccess("editar_novedades"))?true:false', 
			            	),
			            ),
			        ),
			    )
			)); ?>
			</div>
		</div>
		</div>
		<?php endif ?>
		<?php if(Yii::app()->user->checkAccess('ver_concursos')): ?>
		<div class="pull-left">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><span class="glyphicon glyphicon-gift"></span> Concursos publicados <?php echo (Yii::app()->user->checkAccess('crear_concursos')) ? l( '<span class="glyphicon glyphicon-plus"></span>', bu('administrador/concursos/crear'), array('class' => 'pull-right', 'title' => 'Agregar concurso') ):''; ?></h3>
			</div>
			<div class="panel-body">
				<?php $this->widget('zii.widgets.grid.CGridView', array(
				'dataProvider'=>$concursos->search(),
				'enablePagination' => false,
				'summaryText'=>'',  
				'columns'=>array(
			        'nombre',
			        array(
			            'class'=>'CButtonColumn',
			            'template' => '{view} {update}',
			            'viewButtonUrl' => 'Yii::app()->createUrl("/administrador/concursos/view", array("id"=>$data->id))',
			            'buttons' => array(
			            	'update' => array(
			            		'url' => 'Yii::app()->createUrl("/administrador/concursos/update", array("id"=>$data->id))', 
			            		'visible' => '(Yii::app()->user->checkAccess("editar_concursos"))?true:false', 
			            	),
			            ),
			        ),
			    )
			)); ?>
			</div>
		</div>
		</div>
		<?php endif ?>
	<!--</div>-->
</div>
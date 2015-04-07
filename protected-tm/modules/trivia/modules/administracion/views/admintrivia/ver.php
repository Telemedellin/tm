<?php $this->pageTitle = 'Ronda del ' . $model->fecha_inicio . ' al ' . $model->fecha_fin; ?>
<div class="row">
	<div class="col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li><?php echo l('<span class="glyphicon glyphicon-chevron-left"></span> Volver', bu('trivia/administracion'))?></li>
		  <?php if(Yii::app()->user->checkAccess('editar_trivia')): ?>
		  <li><?php echo l('<span class="glyphicon glyphicon-pencil"></span> Editar', bu('trivia/administracion/update/' . $model->id))?></li>
		  <?php endif ?>
		  <?php if(Yii::app()->user->checkAccess('eliminar_trivia')): ?>
		  <li><?php echo l('<small><span class="glyphicon glyphicon-remove"></span> Eliminar</small>', bu('trivia/administracion/delete/' . $model->id), array('onclick' => 'if( !confirm(¿"Seguro que desea borrar la trivia del "<?php echo $model->fecha_inicio; ?> al <?php echo $model->fecha_fin; ?>") ) {return false;}'))?></li>
		  <?php endif ?>
		</ul>
	</div>
	<div class="col-sm-10">
		<h1>Trivia del <?php echo $model->fecha_inicio; ?> al <?php echo $model->fecha_fin; ?></h1>
		<?php
		    foreach(Yii::app()->user->getFlashes() as $key => $message) {
		        echo '<div class="flash-' . $key . ' alert alert-info">' . $message . "</div>\n";
		    }
		?>
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data' => $model, 
			'attributes'=>array(
				'id',
				'fecha_inicio',
				'fecha_fin',
				'puntos',
				array(
					'name' => 'contenido.estado',
					'label' => 'Estado', 
					'value' => ($model->estado==1)?'Publicado':'Desactivado',
				),
			),
		)); ?>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
	<?php 
	if( Yii::app()->user->checkAccess('ver_preguntas') )
	{
		$tabs_content['preguntas'] = 
			array(
	            'title'=>'Preguntas',
	            'view'=>'/pregunta/_preguntas', 
	            'data'=> array('preguntas' => $preguntas, 'model' => $model)
	        );
	}
	if( isset($tabs_content) ) $this->widget('CTabView', array('tabs' => $tabs_content));
	?>
	</div>
</div>
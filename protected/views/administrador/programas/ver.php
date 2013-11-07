<div class="row">
	<div class="col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li><?php echo l('Volver', bu('administrador/programas'))?></li>
		  <li><?php echo l('Editar', bu('administrador/programas/update/' . $model->id))?></li>
		  <li><small><?php echo l('Eliminar', bu('administrador/programas/delete/' . $model->id), array('onclick' => 'if( !confirm(¿"Seguro que desea borrar la novedad "<?php echo $model->nombre; ?>") ) {return false;}'))?></small></li>
		</ul>
	</div>
	<div class="col-sm-10">
		<h1>Programa <?php echo $model->nombre; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data' => array('programa' => $model, 'contenido' => $contenido),
			'attributes'=>array(
				'programa.nombre',
				array(
					'name' => 'programa.url.slug',
					'type' => 'raw', 
					'value' => l($model->url->slug, bu($model->url->slug), array('target' => '_blank')),
				),
				'contenido.resena:html', 
				array(
		            'name' => 'contenido.horario',
		            //'type'=>'time',
		            'value' => Horarios::horario_parser($contenido->horario),
		        ),
				array(
					'name' => 'programa.background', 
					'type' => 'raw', 
					'value' => l($model->background, bu('images/'.$model->background), array('target' => '_blank', 'class' => 'fancybox')),
				),
				array(
					'name' => 'programa.miniatura', 
					'type' => 'raw', 
					'value' => l($model->miniatura, bu('images/'.$model->miniatura), array('target' => '_blank', 'class' => 'fancybox')),
				),
				'programa.creado',
				'programa.modificado',
				array(
					'name' => 'contenido.estado',
					'value' => ($contenido->estado==2)?'En emisión':(($contenido->estado==1)?'No se emite':'Desactivado'),
				),
				'programa.destacado:boolean',
			),
		)); ?>
		<h2>Álbumes de videos</h2>
		<p class="pull-right"><?php echo l('Agregar álbum de videos', bu('administrador/albumvideo/crear/' . $model->id), array('class' => 'btn btn-default btn-sm'))?></p>
		<?php if($videos->getData()): ?>
		<?php $this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$videos,
			'enableSorting' => true,
		    'pager' => array('pageSize' => 25),
		    'htmlOptions' => array('style' => 'clear:both;'), 
			'columns'=>array(
		        'id',
		        array(
		        	'name' => 'nombre',
		        	'value' => '$data->nombre . " (" . count($data->videos) . " videos)"'
		        ),
		        array(
		        	'name' => 'url_id',
		        	'type' => 'html', 
		        	'value' => 'l("'.$model->url->slug.'" . $data->url->slug, "'.bu($model->url->slug).'" . $data->url->slug)'
		        ),
		        array(
		            'name'=>'estado',
		            'filter'=>array('1'=>'Si','0'=>'No'),
		            'value'=>'($data->estado=="1")?("Si"):("No")'
		        ),
		        array(
		            'name'=>'destacado',
		            'filter'=>array('1'=>'Si','0'=>'No'),
		            'value'=>'($data->destacado=="1")?("Si"):("No")'
		        ),
		        array(
		            'class'=>'CButtonColumn',
		            'template' => '{view}{update}{delete}',
		            'viewButtonUrl' => 'Yii::app()->createUrl("/administrador/albumvideo/view", array("id"=>$data->id))',
		            'updateButtonUrl' => 'Yii::app()->createUrl("/administrador/albumvideo/update", array("id"=>$data->id))',
		            'deleteButtonUrl' => 'Yii::app()->createUrl("/administrador/albumvideo/delete", array("id"=>$data->id))',
		        ),
		    )
		)); ?>
	<?php endif; ?>
	</div>
</div>
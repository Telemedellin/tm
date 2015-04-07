	<?php if(Yii::app()->user->checkAccess('crear_videos')): ?>
	<p class="pull-right"><?php echo l('Agregar video', bu('administrador/videos/crear/' . $model->id), array('class' => 'btn btn-default btn-sm', 'target' => '_blank'))?></p>
	<?php endif ?>
	<?php if($videos->getData()): ?>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$videos,
		'enableSorting' => true,
	    'pager' => array('pageSize' => 25),
	    'htmlOptions' => array('style' => 'clear:both;'), 
		'columns'=>array(
	        'id',
	        'nombre', 
	        array(
	        	'name' => 'url_id',
	        	'type' => 'html', 
	        	'value' => 'l($data->url->slug, "'.bu($model->micrositio->url->slug).'" . $data->url->slug)'
	        ),
	        'proveedorVideo.nombre',
	        array(
	        	'name' => 'url_video',
	        	'type' => 'html', 
	        	'value' => 'l($data->url_video, $data->url_video)'
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
	            'buttons'   => array(
	            	'view' => array(
                        'options'   => array('target' => "_blank"),
                        'url'       => 'Yii::app()->createUrl("/administrador/videos/view", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("ver_videos"))?true:false', 
                    ),
                    'update' => array(
                        'options'   => array('target' => "_blank"),
                        'url'       => 'Yii::app()->createUrl("/administrador/videos/update", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("editar_videos"))?true:false', 
                    ),
                    'delete' => array(
                        'url'       => 'Yii::app()->createUrl("/administrador/videos/delete", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("eliminar_videos"))?true:false', 
                    ),
                ),
	        ),
	    )
	)); ?>
	<?php endif; ?>
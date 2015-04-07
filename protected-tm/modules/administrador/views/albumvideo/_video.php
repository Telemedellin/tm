	<?php if(Yii::app()->user->checkAccess('crear_album_videos')): ?>
	<p class="pull-right">
		<?php echo l('Agregar álbum de videos', bu('administrador/albumvideo/crear/' . $model->id), array('class' => 'btn btn-default btn-sm', 'target' => '_blank'))?>
	</p>
	<?php endif ?>
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
	        	'type' => 'html', 
	        	'value' => '$data->nombre . " <span class=\"badge\">" . count($data->videos) . "</span>"'
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
	            'buttons'   => array(
	            	'view' => array(
                        'options'   => array('target' => "_blank"),
                        'url'       => 'Yii::app()->createUrl("/administrador/albumvideo/view", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("ver_album_videos"))?true:false', 
                    ),
                    'update' => array(
                        'options'   => array('target' => "_blank"),
                        'url'       => 'Yii::app()->createUrl("/administrador/albumvideo/update", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("editar_album_videos"))?true:false', 
                    ),
                    'delete' => array(
                        'url'       => 'Yii::app()->createUrl("/administrador/albumvideo/delete", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("eliminar_album_videos"))?true:false', 
                    ),
                ),
	        ),
	    )
	)); ?>
<?php endif; ?>
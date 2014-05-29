	<?php if(Yii::app()->user->checkAccess('crear_album_fotos')): ?>
	<p class="pull-right">
		<?php echo l('Agregar álbum de fotos', bu('administrador/albumfoto/crear/' . $model->id), array('class' => 'btn btn-default btn-sm', 'target' => '_blank'))?>
	</p>
	<?php endif ?>
	<?php if($fotos->getData()): ?>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$fotos,
		'enableSorting' => true,
	    'pager' => array('pageSize' => 25),
	    'htmlOptions' => array('style' => 'clear:both;'), 
		'columns'=>array(
	        'id',
	        array(
	        	'name' => 'nombre',
	        	'type' => 'html', 
	        	'value' => '$data->nombre . " <span class=\"badge\">" . count($data->fotos) . "</span>"'
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
                        'url'       => 'Yii::app()->createUrl("/administrador/albumfoto/view", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("ver_album_fotos"))?true:false', 
                    ),
                    'update' => array(
                        'options'   => array('target' => "_blank"),
                        'url'       => 'Yii::app()->createUrl("/administrador/albumfoto/update", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("editar_album_fotos"))?true:false', 
                    ),
                    'delete' => array(
                        'url'       => 'Yii::app()->createUrl("/administrador/albumfoto/delete", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("eliminar_album_fotos"))?true:false', 
                    ),
                ),
	        ),
	    )
	)); ?>
<?php endif; ?>
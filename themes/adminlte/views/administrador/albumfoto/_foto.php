<div class="row">
	<?php if(Yii::app()->user->checkAccess('crear_album_fotos')): ?>
	<div class="col-sm-12">
        <div class="nav navbar-right btn-group">
            <?php echo l('<i class="fa fa-plus"></i> Agregar álbum de fotos', $this->createUrl('albumfoto/crear', array('id' => $model->id)), array('class' => 'btn btn-primary'))?>
        </div>
    </div>
	<?php endif ?>
	<?php if($fotos->getData()): ?>
	<div class="col-sm-12">
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$fotos,
		'enableSorting' => true,
	    'pager' => array('pageSize' => 25),
	    'htmlOptions' => array('style' => 'clear:both;'), 
		'columns'=>array(
	        array(
	        	'name' => 'nombre',
	        	'type' => 'html', 
	        	'value' => '$data->nombre . " <span class=\"badge bg-olive\">" . count($data->fotos) . "</span>"'
	        ),
	        array(
	        	'name' => 'url_id',
	        	'type' => 'html', 
	        	'value' => 'l("<i class=\"fa fa-external-link\"></i> '.$model->url->slug.'" . $data->url->slug, "'.bu($model->url->slug).'" . $data->url->slug, array("target" => "_blank"))'
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
	            'template' => '{view} | {update} | {delete}',
	            'buttons'   => array(
	            	'view' => array(
                        'url'       => 'Yii::app()->createUrl("albumfoto/view", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("ver_album_fotos"))?true:false', 
                        'imageUrl' => false,
                        'label'    => '<i class="fa fa-search"></i>', 
                        'options'  => array('title' => 'Ver detalles'),
                    ),
                    'update' => array(
                        'url'       => 'Yii::app()->createUrl("albumfoto/update", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("editar_album_fotos"))?true:false', 
                        'imageUrl' => false,
                        'label'    => '<i class="fa fa-pencil"></i>', 
                        'options'  => array('title' => 'Editar'), 
                    ),
                    'delete' => array(
                        'url'       => 'Yii::app()->createUrl("albumfoto/delete", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("eliminar_album_fotos"))?true:false',
                        'imageUrl' => false,
                        'label' => '<i class="fa fa-trash-o"></i>', 
                        'options'  => array('title' => 'Eliminar'), 
                    ),
                ),
	        ),
	    )
	)); ?>
	</div>
<?php endif; ?>
</div>
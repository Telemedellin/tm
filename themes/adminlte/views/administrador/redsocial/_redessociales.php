<div class="row">
    <?php if(Yii::app()->user->checkAccess('crear_redes_socialess')): ?>
    <div class="col-sm-12">
        <div class="nav navbar-right btn-group">
            <?php echo l('<i class="fa fa-plus"></i> Agregar red social', bu('administrador/redsocial/crear/' . $model->id), array('class' => 'btn btn-primary'))?>
        </div>
    </div>
    <?php endif ?>
    <?php if($redes_sociales->getData()): ?>
    <div class="col-sm-12">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$redes_sociales,
        'enableSorting' => true,
        'htmlOptions' => array('style' => 'clear:both;'), 
        'columns'=>array(
            array(
                'header' => 'Red social', 
                'type' => 'raw', 
                'value' => '(l("<i class=\"fa fa-".strtolower($data->tipoRedSocial->nombre)."\"></i> " . $data->tipoRedSocial->nombre, $data->tipoRedSocial->url_base . $data->usuario, array("target" => "_blank")))'
            ),
            array(
                'name'=>'estado',
                'filter'=>array('1'=>'Si','0'=>'No'),
                'value'=>'($data->estado=="1")?("Si"):("No")'
            ),
            array(
                'class'=>'CButtonColumn',
                'template' => '{update} | {delete}',
                'buttons'   => array(
                    'update' => array(
                        'options'   => array('target' => "_blank"),
                        'url'       => 'Yii::app()->createUrl("/administrador/redsocial/update", array("id"=>$data->id))', 
                        'visible'   => '(Yii::app()->user->checkAccess("editar_redes_sociales"))?true:false',
                        'imageUrl' => false,
                        'label'    => '<i class="fa fa-pencil"></i>', 
                        'options'  => array('title' => 'Editar'),  
                    ),
                    'delete' => array(
                        'url'       => 'Yii::app()->createUrl("/administrador/redsocial/delete", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("eliminar_redes_sociales"))?true:false', 
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
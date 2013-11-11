<p class="pull-right">
    <?php echo l('Agregar red social', bu('administrador/redsocial/crear/' . $model->id), array('class' => 'btn btn-default btn-sm', 'role' => 'button'))?>
</p>
<?php //print_r($redes_sociales->getData()); ?>
<?php if($redes_sociales->getData()): ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$redes_sociales,
    'enableSorting' => true,
    'htmlOptions' => array('style' => 'clear:both;'), 
    'columns'=>array(
        'id',
        array(
            'header' => 'Red social', 
            'type' => 'raw', 
            'value' => '(l($data->tipoRedSocial->nombre, $data->tipoRedSocial->url_base . $data->usuario, array("target" => "_blank")))'
        ),
        array(
            'name'=>'estado',
            'filter'=>array('1'=>'Si','0'=>'No'),
            'value'=>'($data->estado=="1")?("Si"):("No")'
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{update}{delete}',
            'updateButtonUrl' => 'Yii::app()->createUrl("/administrador/redsocial/update", array("id"=>$data->id))',
            'deleteButtonUrl' => 'Yii::app()->createUrl("/administrador/redsocial/delete", array("id"=>$data->id))',
        ),
    )
)); ?>
<?php endif; ?>
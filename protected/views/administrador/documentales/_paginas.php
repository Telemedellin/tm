<p class="pull-right">
    <?php echo l('Agregar pagina', bu('administrador/pagina/crear/' . $model->id), array('class' => 'btn btn-default btn-sm', 'role' => 'button'))?>
</p>
<?php if($paginas->getData()): ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$paginas,
	'enableSorting' => true,
    'pager' => array('pageSize' => 25),
    'htmlOptions' => array('style' => 'clear:both;'), 
	'columns'=>array(
        'nombre', 
        'pgDocumentals.titulo',
        'pgDocumentals.duracion',
        'pgDocumentals.anio',
        array(
                'name' => 'url_id',
                'type' => 'raw', 
                'value' => 'l($data->url->slug, bu($data->url->slug), array("target" => "_blank"))'
            ),
        array(
            'name'=>'estado',
            'filter'=>array('1'=>'Si','0'=>'No'),
            'value'=>'($data->estado=="1")?("Si"):("No")'
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{update}'/*{delete}'*/,
            'updateButtonUrl' => 'Yii::app()->createUrl("/administrador/pagina/update", array("id"=>$data->id))',
            //'deleteButtonUrl' => 'Yii::app()->createUrl("/administrador/pagina/delete", array("id"=>$data->id))',
            'updateButtonOptions' => array('target' => "_blank"),
        ),
    )
)); ?>
<?php endif; ?>
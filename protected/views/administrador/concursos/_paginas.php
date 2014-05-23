<div class="btn-group pull-right">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    Agregar página <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><?php echo l('Genérica', bu('administrador/pagina/crear/' . $model->id), array('target' => '_blank'))?></li>
    <li><?php echo l('Bloques', bu('administrador/pagina/crear/' . $model->id . '/10'), array('target' => '_blank'))?></li>
    <li><?php echo l('Página de blog', bu('administrador/pagina/crear/' . $model->id . '/3'), array('target' => '_blank'))?></li>
    <li><?php echo l('Eventos', bu('administrador/pagina/crear/' . $model->id . '/12'), array('target' => '_blank'))?></li>
    <li><?php echo l('Blog', bu('administrador/pagina/crear/' . $model->id . '/11'), array('target' => '_blank'))?></li>
    <li><?php echo l('Filtro', bu('administrador/pagina/crear/' . $model->id . '/8'), array('target' => '_blank'))?></li>
  </ul>
</div>
<?php if($paginas->getData()): ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$paginas,
	'enableSorting' => true,
    'pager' => array('pageSize' => 25),
    'htmlOptions' => array('style' => 'clear:both;'), 
	'columns'=>array(
        'nombre',
         array(
                'name' => 'url_id',
                'type' => 'raw', 
                'value' => 'l($data->url->slug, bu($data->url->slug), array("target" => "_blank"))'
            ),
        'pgGenericaSt.imagen', 
        'pgGenericaSt.miniatura', 
        array(
            'name'=>'estado',
            'filter'=>array('1'=>'Si','0'=>'No'),
            'value'=>'($data->estado=="1")?("Si"):("No")'
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{update}{delete}',
            'updateButtonUrl' => 'Yii::app()->createUrl("/administrador/pagina/update", array("id"=>$data->id))',
            'deleteButtonUrl' => 'Yii::app()->createUrl("/administrador/pagina/delete", array("id"=>$data->id))',
            'updateButtonOptions' => array('target' => "_blank"),
        ),
    )
)); ?>
<?php endif; ?>
<h2>Páginas</h2>
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
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$paginas,
	'enableSorting' => true,
    'pager' => array('pageSize' => 25),
    'htmlOptions' => array('style' => 'clear:both;'), 
	'columns'=>array(
        'id',
        'nombre',
        'creado',
        'modificado',
        array(
            'name'=>'estado',
            'header'=>'Publicado',
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
            'viewButtonUrl' => 'Yii::app()->createUrl("/administrador/pagina/view", array("id"=>$data->id))',
            'updateButtonUrl' => 'Yii::app()->createUrl("/administrador/pagina/update", array("id"=>$data->id))',
            'deleteButtonUrl' => 'Yii::app()->createUrl("/administrador/pagina/delete", array("id"=>$data->id))',
            'viewButtonOptions' => array('target' => "_blank"),
    		'updateButtonOptions' => array('target' => "_blank"),
        ),
    )
)); ?>
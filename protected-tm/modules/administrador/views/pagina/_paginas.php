<?php if(Yii::app()->user->checkAccess('crear_paginas')): ?>
<div class="btn-group pull-right">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    Agregar página <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">
    <li><?php echo l('Genérica', bu('administrador/pagina/crear/' . $model->id), array('target' => '_blank'))?></li>
    <li><?php echo l('Bloques', bu('administrador/pagina/crear/' . $model->id . '/10'), array('target' => '_blank'))?></li>
    <li><?php echo l('Novedad en blog', bu('administrador/pagina/crear/' . $model->id . '/3'), array('target' => '_blank'))?></li>
    <li><?php echo l('Eventos', bu('administrador/pagina/crear/' . $model->id . '/12'), array('target' => '_blank'))?></li>
    <li><?php echo l('Blog', bu('administrador/pagina/crear/' . $model->id . '/11'), array('target' => '_blank'))?></li>
    <li><?php echo l('Filtro', bu('administrador/pagina/crear/' . $model->id . '/8'), array('target' => '_blank'))?></li>
  </ul>
</div>
<?php endif ?>
<?php if($paginas): ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'  => $paginas->search(),
    'filter'        => $paginas, 
    'enableSorting' => true,
    'pager'         => array('pageSize' => 25),
    'htmlOptions'   => array('style' => 'clear:both;'), 
    'columns'       => array(
        'nombre',
        array(
            'name' => 'url_slug',
            'type' => 'raw', 
            'value' => 'l($data->url->slug, bu($data->url->slug), array("target" => "_blank"))'
        ),
        array(
            'name'   => 'tipo_pagina',
            'value'  => '$data->tipoPagina->nombre', 
            'filter' => CHtml::listData(TipoPagina::model()->findAll(), 'id', 'nombre'),
        ),
        array(
            'name' => 'pgGenericaSt.imagen',
            'visible' => isset($data->pgGenericaSts), 
        ),
        array(
            'name' => 'pgGenericaSt.imagen_mobile',
            'visible' => isset($data->pgGenericaSts->imagen_mobile), 
        ),
        array(
            'name' => 'pgGenericaSt.miniatura',
            'visible' => isset($data->pgGenericaSts), 
        ),
        array(
            'name' => 'pgDocumentals.titulo',
            'visible' => ( isset($data->pgDocumentals) && !is_null($data->pgDocumentals->titulo) )?true:false , 
        ),
        array(
            'name' => 'pgDocumentals.duracion',
            'visible' => isset($data->pgDocumentals), 
        ),
        array(
            'name' => 'pgDocumentals.anio',
            'visible' => isset($data->pgDocumentals), 
        ),
        array(
            'name'=>'estado',
            'filter'=>array('2'=>'Sí','1'=>'Archivado', '0'=>'No'),
            'value'=>'($data->estado==2)?"Sí":( ($data->estado==1)?"Archivado":"No" )'
        ),
        array(
            'class'=>'CButtonColumn',
            'template'  => '{view}{update}{delete}',
            'buttons'   => array(
                'view' => array(
                    'options'   => array('target' => "_blank"),
                    'url'       => 'Yii::app()->createUrl("/administrador/pagina/view", array("id"=>$data->id))',
                    'visible'   => '(Yii::app()->user->checkAccess("ver_paginas"))?true:false', 
                ),
                'update' => array(
                    'options'   => array('target' => "_blank"),
                    'url'       => 'Yii::app()->createUrl("/administrador/pagina/update", array("id"=>$data->id))', 
                    'visible'   => '(Yii::app()->user->checkAccess("editar_paginas"))?true:false', 
                ),
                'delete' => array(
                    'url'       => 'Yii::app()->createUrl("/administrador/pagina/delete", array("id"=>$data->id))',
                    'visible'   => '(Yii::app()->user->checkAccess("eliminar_paginas"))?true:false', 
                ),
            ),
        ),
    )
)); ?>
<?php endif; ?>
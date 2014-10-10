<div class="row">
    <?php if(Yii::app()->user->checkAccess('crear_paginas')): ?>
    <div class="col-sm-12">
        <div class="nav navbar-right btn-group">
            <?php echo CHtml::htmlButton('<i class="fa fa-plus"></i> Agregar página', array('class' => 'btn btn-primary')) ?>
            <?php echo CHtml::htmlButton('<span class="caret"></span> <span class="sr-only">Activar submenú</span>', array('class' => 'btn btn-primary dropdown-toggle', 'data-toggle' => 'dropdown')) ?>
            <ul class="dropdown-menu" role="menu">
                <li><?php echo l('Genérica', bu('administrador/pagina/crear/' . $model->id))?></li>
                <li><?php echo l('Novedad en blog', bu('administrador/pagina/crear/' . $model->id . '/3'))?></li>
                <li class="divider"></li>
                <li><?php echo l('Bloques', bu('administrador/pagina/crear/' . $model->id . '/10'))?></li>
                <li><?php echo l('Blog', bu('administrador/pagina/crear/' . $model->id . '/11'))?></li>
                <li><?php echo l('Eventos', bu('administrador/pagina/crear/' . $model->id . '/12'))?></li>
                <li><?php echo l('Filtro', bu('administrador/pagina/crear/' . $model->id . '/8'))?></li>
            </ul>
        </div>
    </div>
    <?php endif ?>
    <?php if($paginas): ?>
    <div class="col-sm-12">
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
                'value' => 'l("<i class=\"fa fa-external-link\"></i> " . $data->url->slug, bu($data->url->slug), array("target" => "_blank"))'
            ),
            array(
                'name'   => 'tipo_pagina',
                'value'  => '$data->tipoPagina->nombre', 
                'filter' => CHtml::listData(TipoPagina::model()->findAll(), 'id', 'nombre'),
            ),
            array(
                'name' => 'pgGenericaSt.imagen',
                'visible' => isset($data->pgGenericaSts), 
                'value' => '($data->imagen)?l("<i class=\"fa fa-picture-o\"></i> " . $data->imagen, bu("\"images/".$data->imagen), array("target" => "_blank", "class" => "fancybox")):"No asignada"'
            ),
            array(
                'name' => 'pgGenericaSt.imagen_mobile',
                'visible' => isset($data->pgGenericaSts->imagen_mobile), 
                'value' => '($data->imagen_mobile)?l("<i class=\"fa fa-picture-o\"></i> " . $data->imagen_mobile, bu("\"images/".$data->imagen_mobile), array("target" => "_blank", "class" => "fancybox")):"No asignada"'
            ),
            array(
                'name' => 'pgGenericaSt.miniatura',
                'visible' => isset($data->pgGenericaSts), 
                'value' => '($data->miniatura)?l("<i class=\"fa fa-picture-o\"></i> " . $data->miniatura, bu("\"images/".$model->miniatura), array("target" => "_blank", "class" => "fancybox")):"No asignada"'
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
                'template'  => '{view} | {update} | {delete}',
                'buttons'   => array(
                    'view' => array(
                        'url'       => 'Yii::app()->createUrl("/administrador/pagina/view", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("ver_paginas"))?true:false', 
                        'imageUrl' => false,
                        'label'    => '<i class="fa fa-search"></i>', 
                        'options'  => array('title' => 'Ver detalles', 'target' => "_blank"),
                    ),
                    'update' => array(
                        'url'       => 'Yii::app()->createUrl("/administrador/pagina/update", array("id"=>$data->id))', 
                        'visible'   => '(Yii::app()->user->checkAccess("editar_paginas"))?true:false',
                        'imageUrl' => false,
                        'label'    => '<i class="fa fa-pencil"></i>', 
                        'options'  => array('title' => 'Editar', 'target' => "_blank"), 
                    ),
                    'delete' => array(
                        'url'       => 'Yii::app()->createUrl("/administrador/pagina/delete", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("eliminar_paginas"))?true:false', 
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
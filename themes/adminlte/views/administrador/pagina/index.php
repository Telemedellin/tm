<?php
$this->pageTitle = 'Página ' . Yii::app()->name; 
$bc = array();
$bc[] = 'Página';
$this->breadcrumbs = $bc;
$this->renderPartial('//layouts/commons/_flashes');
?>
<div class="col-sm-12">
    <div class="nav navbar-right">
      <?php if(Yii::app()->user->checkAccess('crear_pagina')): ?>
            <?php echo l('<i class="fa fa-plus"></i> Nueva', $this->createUrl('crear'), array('class' => 'btn btn-primary')) ?>
      <?php endif ?>
    </div>
</div>
<div class="col-sm-12">
    <?php 
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$dataProvider->search(),
        'filter' => $$dataProvider, 
        'enableSorting' => true,
        'columns'=>array(
            array(
                'name'=>'Nombre',
                'value'=>'l($data->nombre, bu($data->url->slug) )',
                'type'=>'html'
            ),
            array(
                'name'=>'Micrositio',
                'value'=>'l($data->micrositio->nombre, bu($data->micrositio->url->slug) )',
                'type'=>'html'
            ),
            array(
                'name'=>'Tipo de página',
                'value'=>'$data->tipoPagina->nombre',
            ),
            array(
                'name'=>'creado',
                'value'=>'date("Y-m-d H:i:s", $data->creado)',
            ),
            array(
                'name'=>'modificado',
                'value'=>'date("Y-m-d H:i:s", $data->modificado)',
            ),
            'estado',
            'destacado',
            array(
                    'class'=>'CButtonColumn',
                    'template' => '{view} | {update} | {delete}',
                    'buttons' => array(
                        'view' => array(
                            'imageUrl' => false,
                            'label'    => '<i class="fa fa-search"></i>', 
                        'options'  => array('title' => 'Ver detalles'),
                        ),
                        'update' => array(
                            'visible' => '(Yii::app()->user->checkAccess("editar_menus"))?true:false', 
                            'imageUrl' => false,
                            'label'    => '<i class="fa fa-pencil"></i>', 
                        'options'  => array('title' => 'Editar'),
                        ),
                        'delete' => array(
                            'visible' => '(Yii::app()->user->checkAccess("eliminar_menus"))?true:false', 
                            'imageUrl' => false,
                            'label' => '<i class="fa fa-trash-o"></i>', 
                            'options'  => array('title' => 'Eliminar'),
                        ),
                    ),
                ),
            ),
        )
    ));
?>
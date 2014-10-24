<?php
$this->pageTitle = 'Vídeos ' . Yii::app()->name; 
$bc = array();
$bc[] = 'Vídeos';
$this->breadcrumbs = $bc;
$this->renderPartial('//layouts/commons/_flashes');
?>
<div class="col-sm-12">
    <div class="nav navbar-right">
      <?php if(Yii::app()->user->checkAccess('crear_videos')): ?>
            <?php echo l('<i class="fa fa-plus"></i> Nueva', $this->createUrl('crear'), array('class' => 'btn btn-primary')) ?>
      <?php endif ?>
    </div>
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'enableSorting' => true,
    'pager' => array('pageSize' => 25),
	'columns'=>array(
        'id',
        array(
            'name' => 'nombre', 
            'type' => 'raw', 
            'value' => 'l($data->nombre, bu($data->url->slug), array("target" => "_blank"))',
        ),
        array(
            'name' => 'albumVideo.nombre', 
            'header' => 'Álbum'
        ),
        array(
            'name' => 'proveedorVideo.nombre', 
            'type' => 'raw', 
            'value' => 'l($data->proveedorVideo->nombre, $data->url_video, array("target" => "_blank"))',
        ),
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
        ),
    )
)); ?>
<div class="col-sm-12">
    <?php 
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$dataProvider->search(),
        'filter' => $dataProvider, 
        'enableSorting' => true,
        'columns'=>array(
                array(
                    'name' => 'nombre', 
                    'type' => 'raw', 
                    'value' => 'l($data->nombre, bu($data->url->slug), array("target" => "_blank"))',
                ),
                array(
                    'name' => 'albumVideo.nombre', 
                    'header' => 'Álbum'
                ),
                array(
                    'name' => 'proveedorVideo.nombre', 
                    'type' => 'raw', 
                    'value' => 'l($data->proveedorVideo->nombre, $data->url_video, array("target" => "_blank"))',
                ),
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
                            'label'    => '<i class="fa fa-search"></i>', 
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
        )
    ));
?>
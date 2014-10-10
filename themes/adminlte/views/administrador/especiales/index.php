<?php
$this->pageTitle = 'Especiales ' . Yii::app()->name; 
$bc = array();
$bc[] = 'Especiales';
$this->breadcrumbs = $bc;
$this->renderPartial('//layouts/commons/_flashes');
?>
<div class="col-sm-12">
    <div class="nav navbar-right">
      <?php if(Yii::app()->user->checkAccess('crear_especiales')): ?>
            <?php echo l('<i class="fa fa-plus"></i> Nueva', bu('administrador/especiales/crear/'), array('class' => 'btn btn-primary')) ?>
      <?php endif ?>
    </div>
</div>
<div class="col-sm-12">
    <?php 
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$model->search(),
        'filter' => $model, 
        'enableSorting' => true,
        'columns'=>array(
            array(
                'name'=>'nombre',
                'header'=>'Nombre',
                'type' => 'raw', 
                'value'=>'$data->nombre'
            ),
            'creado',
            'modificado',
            array(
                'name'=>'estado',
                'header'=>'Publicado',
                'filter'=>array('2'=>'Publicado', '1'=>'Archivado','0'=>'Desactivado'),
                'value'=>'($data->estado=="2")?("Publicado"):(($data->estado=="1")?("Archivado"):("Desactivado"))'
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
                        'visible' => '(Yii::app()->user->checkAccess("editar_especiales"))?true:false',  
                        'imageUrl' => false,
                        'label'    => '<i class="fa fa-pencil"></i>', 
                        'options'  => array('title' => 'Editar'),
                    ),
                    'delete' => array(
                        'visible' => '(Yii::app()->user->checkAccess("eliminar_especiales"))?true:false', 
                        'imageUrl' => false,
                        'label' => '<i class="fa fa-trash-o"></i>', 
                        'options'  => array('title' => 'Eliminar'),
                    ),
                ),
            ),
        )
    ));
?>
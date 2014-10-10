<?php
$this->pageTitle = 'Novedades ' . Yii::app()->name; 
$bc = array();
$bc[] = 'Novedades';
$this->breadcrumbs = $bc;
$this->renderPartial('//layouts/commons/_flashes');
?>
<div class="col-sm-12">
    <div class="nav navbar-right">
      <?php if(Yii::app()->user->checkAccess('crear_novedades')): ?>
            <?php echo l('<i class="fa fa-plus"></i> Nueva', bu('administrador/novedades/crear/'), array('class' => 'btn btn-primary')) ?>
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
                'header'=>'Estado',
                'value'=>'($data->estado=="2")?("En home"):(($data->estado=="1")?("Archivado"):("Desactivado"))',
                'filter' => array('2' => 'En home', '1'=>'Archivado', '0'=>'Desactivado'),
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
                        'visible' => '(Yii::app()->user->checkAccess("editar_novedades"))?true:false', 
                        'imageUrl' => false,
                        'label'    => '<i class="fa fa-pencil"></i>', 
                        'options'  => array('title' => 'Editar'),
                    ),
                    'delete' => array(
                        'visible' => '(Yii::app()->user->checkAccess("eliminar_novedades"))?true:false', 
                        'imageUrl' => false,
                        'label' => '<i class="fa fa-trash-o"></i>', 
                        'options'  => array('title' => 'Eliminar'),
                    ),
                ),
            ),
        )
    ));
?>
</div>
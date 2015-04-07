<?php
$this->pageTitle = 'Programas ' . Yii::app()->name; 
$bc = array();
$bc[] = 'Programas';
$this->breadcrumbs = $bc;
$this->renderPartial('//layouts/commons/_flashes');
?>
<div class="col-sm-12">
    <div class="nav navbar-right">
      <?php if(Yii::app()->user->checkAccess('crear_programas')): ?>
            <?php echo l('<i class="fa fa-plus"></i> Nuevo', $this->createUrl('crear'), array('class' => 'btn btn-primary')) ?>
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
            'nombre',
            'creado',
            'modificado',
              array(
                'name'=>'estado',
                'header'=>'Publicado',
                'filter'=>array('' => 'Todos', '2'=>'En emisión', '1'=>'No se emite','0'=>'Value'),
                'value'=>'($data->estado=="2")?("En emisión"):(($data->estado=="1")?("No se emite"):("Desactivado"))'
            ),
            array(
                'name'=>'destacado',
                'filter'=>array('' => 'Todos', '1'=>'Sí','0'=>'No'),
                'value'=>'($data->destacado=="1")?("Sí"):("No")'
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
                        'visible' => '(Yii::app()->user->checkAccess("editar_programas"))?true:false',  
                        'imageUrl' => false,
                        'label'    => '<i class="fa fa-pencil"></i>', 
                        'options'  => array('title' => 'Editar'),
                    ),
                    'delete' => array(
                        'visible' => '(Yii::app()->user->checkAccess("eliminar_programas"))?true:false', 
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
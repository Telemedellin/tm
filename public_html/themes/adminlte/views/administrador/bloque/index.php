<?php
$this->pageTitle = 'Bloques ' . Yii::app()->name; 
$bc = array();
$bc[] = 'Bloques';
$this->breadcrumbs = $bc;
$this->renderPartial('//layouts/commons/_flashes');
?>
<div class="col-sm-12">
    <div class="nav navbar-right">
      <?php if(Yii::app()->user->checkAccess('crear_bloques')): ?>
            <?php echo l('<i class="fa fa-plus"></i> Nueva', $this->createUrl('bloques/crear', array('id' => $model->id)), array('class' => 'btn btn-primary')) ?>
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
                        'name'=>'nombre',
                        'header'=>'Nombre',
                        'type' => 'raw', 
                        'value'=>'$data->nombre'
                    ),
                    'creado',
                    'modificado',
                    array(
                        'name'=>'estado',
                        'filter'=>array('' => 'Todos', '1'=>'Publicado','0'=>'Desactivado'),
                        'value'=>'($data->estado=="1")?("Publicado"):("Desactivado")'
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
                                'imageUrl' => false,
                                'label'    => '<i class="fa fa-pencil"></i>', 
                                'options'  => array('title' => 'Editar'),
                            ),
                            'delete' => array(
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
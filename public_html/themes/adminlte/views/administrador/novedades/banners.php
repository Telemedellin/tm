<?php
$this->pageTitle = 'Banners ' . Yii::app()->name; 
$bc = array();
$bc[] = 'Banners';
$this->breadcrumbs = $bc;
$this->renderPartial('//layouts/commons/_flashes');
?>
<div class="col-sm-12">
    <div class="nav navbar-right">
      <?php if(Yii::app()->user->checkAccess('crear_banners')): ?>
            <?php echo l('<i class="fa fa-plus"></i> Nuevo', $this->createUrl('crearbanner', array('id' => $model->id)), array('class' => 'btn btn-primary')) ?>
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
            'inicio_publicacion',
            'fin_publicacion',
             array(
                'name'=>'estado',
                'value'=>'($data->estado=="1")?("Publicado"):("Desactivado")',
                'filter' => array('' => 'Todos', '1' => 'Publicado', '2' => 'Desactivado'),
             ),
            array(
                'class'=>'CButtonColumn',
                'template' => '{view} | {update} | {delete}',
                'buttons' => array(
                    'view' => array(
                        'url' => 'Yii::app()->createUrl("administrador/novedades/viewbanner", array("id"=>$data->id))', 
                        'imageUrl' => false,
                        'label'    => '<i class="fa fa-search"></i>', 
                        'options'  => array('title' => 'Ver detalles'),
                    ),
                    'update' => array(
                        'visible' => '(Yii::app()->user->checkAccess("editar_banners"))?true:false', 
                        'url' => 'Yii::app()->createUrl("administrador/novedades/updatebanner", array("id"=>$data->id))', 
                        'imageUrl' => false,
                        'label'    => '<i class="fa fa-pencil"></i>', 
                        'options'  => array('title' => 'Editar'),
                    ),
                    'delete' => array(
                        'visible' => '(Yii::app()->user->checkAccess("eliminar_banners"))?true:false',
                        'url' => 'Yii::app()->createUrl("administrador/novedades/deletebanner", array("id"=>$data->id))',
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
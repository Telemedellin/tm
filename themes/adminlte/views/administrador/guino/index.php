<?php
$this->pageTitle = 'Guiños ' . Yii::app()->name; 
$bc = array();
$bc[] = 'Guiños';
$this->breadcrumbs = $bc;
$this->renderPartial('//layouts/commons/_flashes');
?>
<div class="col-sm-12">
    <div class="nav navbar-right">
      <?php if(Yii::app()->user->checkAccess('crear_guinos')): ?>
            <?php echo l('<i class="fa fa-plus"></i> Nuevo', $this->createUrl('crear'), array('class' => 'btn btn-primary')) ?>
      <?php endif ?>
    </div>
</div>
<div class="col-sm-12">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$model->search(),
    'filter' => $model, 
	'enableSorting' => true,
    'columns'=>array(
        'id',
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
            'header'=>'Publicado',
            'value'=>'($data->estado=="1")?("Sí"):("No")',
            'filter' => array('1' => 'Sí', '2' => 'No'),
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{view} | {update} | {delete}',
            'buttons' => array(
                'view' => array(
                    'url' => 'Yii::app()->createUrl("guino/view", array("id"=>$data->id))', 
                    'imageUrl' => false,
                    'label'    => '<i class="fa fa-search"></i>', 
                    'options'  => array('title' => 'Ver detalles'),
                ),
                'update' => array(
                    'visible' => '(Yii::app()->user->checkAccess("editar_guinos"))?true:false', 
                    'url' => 'Yii::app()->createUrl("guino/update", array("id"=>$data->id))', 
                    'imageUrl' => false,
                    'label'    => '<i class="fa fa-pencil"></i>', 
                    'options'  => array('title' => 'Editar'),
                ),
                'delete' => array(
                    'visible' => '(Yii::app()->user->checkAccess("eliminar_guinos"))?true:false',
                    'url' => 'Yii::app()->createUrl("guino/delete", array("id"=>$data->id))',
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

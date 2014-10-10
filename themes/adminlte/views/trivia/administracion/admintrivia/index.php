<?php 
$this->pageTitle = 'Trivias'; 
$bc = array();
$bc[] = 'Trivias';
$this->breadcrumbs = $bc;
$this->renderPartial('//layouts/commons/_flashes');
?>
<div class="col-sm-12">
    <div class="nav navbar-right">
      <?php if(Yii::app()->user->checkAccess('crear_trivia')): ?>
            <?php echo l('<i class="fa fa-plus"></i> Nueva', bu('trivia/administracion/crear'), array('class' => 'btn btn-primary')) ?>
      <?php endif ?>
    </div>
</div>
<div class="col-sm-12">
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider' => $model->search(),
    'filter' => $model, 
	'enableSorting' => true,
	'columns'=>array(
        'id',
        'fecha_inicio',
        'fecha_fin',
        array(
            'header' => 'Preguntas', 
            'value'  => 'count($data->rondaXPreguntas)', 
        ),
        'puntos',
        array(
            'name'=>'estado',
            'header'=>'Publicado',
            'filter'=>array('1'=>'Si','0'=>'No'),
            'value'=>'($data->estado=="1")?("Sí"):("No")'
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
                    'visible' => '(Yii::app()->user->checkAccess("editar_trivia"))?true:false', 
                    'imageUrl' => false,
                    'label'    => '<i class="fa fa-pencil"></i>', 
                    'options'  => array('title' => 'Editar'),
                ),
                'delete' => array(
                    'visible' => '(Yii::app()->user->checkAccess("eliminar_trivia"))?true:false', 
                    'imageUrl' => false,
                    'label' => '<i class="fa fa-trash-o"></i>', 
                    'options'  => array('title' => 'Eliminar'),
                ),
            ),
        ),
    )
)); ?>

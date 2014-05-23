<?php if($menu): ?>
    <p class="pull-right">
        <?php echo l('Agregar item de menú', bu('administrador/menu/crearitem/' . $model->menu_id), array('class' => 'btn btn-default btn-sm', 'target' => '_blank'))?>
    </p>
    <p>Este micrositio tiene asignado el menú <strong><?php echo $model->menu->nombre; ?></strong> <a href="<?php echo bu('administrador/especiales/desasignarmenu/' . $model->id) ?>"><small>Desasignar</small></a></p>
    <?php if($menu->getData()): ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
    	'dataProvider'=>$menu,
    	'enableSorting' => true,
        'pager' => array('pageSize' => 25),
        'htmlOptions' => array('style' => 'clear:both;'), 
    	'columns'=>array(
            'label',
            array(
                'header' => 'URL',
                'type' => 'raw', 
                'value' => function($data){
                    if($data->urlx)return l($data->urlx->slug, bu($data->urlx->slug), array("target" => "_blank"));
                    else return l($data->url, $data->url, array("target" => "_blank"));
                }
            ),
            array(
                'name'=>'estado',
                'filter'=>array('1'=>'Si','0'=>'No'),
                'value'=>'($data->estado=="1")?("Si"):("No")'
            ),
            array(
                'class'=>'CButtonColumn',
                'template' => '{update} {delete}',
                'updateButtonUrl' => 'Yii::app()->createUrl("/administrador/menu/updateitem", array("id"=>$data->id))',
                'updateButtonOptions' => array('target' => "_blank"),
                'deleteButtonUrl' => 'Yii::app()->createUrl("/administrador/menu/deleteitem", array("id"=>$data->id))',
                'deleteConfirmation' => '¿Realmente desea eliminar este item?'
            ),
        )
    )); ?>
    <?php endif; ?>
<?php else: ?>
    <h3>Asignación de menú</h3>
    <p>Este micrositio no tiene un menú asignado, asigne un menú existente abajo o <?php echo l('Cree un menú', bu('administrador/menu/crear/' . $model->id), array('class' => 'btn btn-default btn-sm', 'target' => '_blank'))?> para asignarselo.</p>
    <div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'menu-form',
        'enableAjaxValidation'=>false,
        'htmlOptions' => array( 
            'role' => 'form',
            'class' => 'form-horizontal' 
        )
    )); ?>
    <div class="form-group">
        <?php echo $form->label($model, 'menu_id', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
            <?php echo $form->dropDownList($model, 'menu_id', CHtml::listData(Menu::model()->findAll('id != 1'), 'id', 'nombre'), array('class' => 'form-control') ); ?>
        </div>
        <div class="col-sm-4">
            <?php echo CHTML::hiddenField('asignar_menu', 'true'); ?>
            <?php echo CHtml::submitButton('Asignar', array('class' => 'btn btn-primary asignar')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
    </div>
<?php endif; ?>
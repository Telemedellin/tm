<div class="row">
<?php if($menu): ?>
    <?php if(Yii::app()->user->checkAccess('crear_menu_item')): ?>
    <div class="col-sm-12">
        <div class="nav navbar-right btn-group">
            <?php echo l('<i class="fa fa-plus"></i> Agregar item de menú', $this->createUrl('menu/crearitem', array('id' => $model->menu_id)), array('class' => 'btn btn-primary'))?>
        </div>
    </div>
    <?php endif ?>
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Asignación de menú</h3>
            </div>
            <div class="box-body">
                <div class="alert alert-info alert-dismissable">
                    <i class="fa fa-info"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    Este micrositio tiene asignado el menú <b><?php echo $model->menu->nombre; ?></b> 
                    <?php if(Yii::app()->user->checkAccess('asignar_menu_'.strtolower($this->ID)) || Yii::app()->user->checkAccess('asignar_menus') ): ?>
                    <a href="<?php echo $this->createUrl(strtolower($this->ID).'/desasignarmenu', array('id' => $model->id)) ?>" class="btn btn-danger btn-xs">
                        <small><i class="fa fa-times"></i> Desasignar</small>
                    </a>
                    <? endif ?>
                </div>
                <?php if(Yii::app()->user->checkAccess('ver_menu_item')): ?>
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
                                if($data->urlx)return l("<i class=\"fa fa-external-link\"></i> ".$data->urlx->slug, bu($data->urlx->slug), array("target" => "_blank"));
                                else return l("<i class=\"fa fa-external-link\"></i> ".$data->url, $data->url, array("target" => "_blank"));
                            }
                        ),
                        array(
                            'name'=>'estado',
                            'filter'=>array('' => 'Todos', '1'=>'Publicado','0'=>'Desactivado'),
                            'value'=>'($data->estado=="1")?("Publicado"):("Desactivado")'
                        ),
                        array(
                            'class'=>'CButtonColumn',
                            'template'  => '{update} | {delete}',
                            'deleteConfirmation' => '¿Realmente desea eliminar este item?', 
                            'buttons'   => array(
                                'update' => array(
                                    'url'       => 'Yii::app()->createUrl("administrador/menu/updateitem", array("id"=>$data->id))',
                                    'visible'   => '(Yii::app()->user->checkAccess("editar_menu_item"))?true:false', 
                                    'imageUrl' => false,
                                    'label'    => '<i class="fa fa-pencil"></i>', 
                                    'options'  => array('title' => 'Editar'), 
                                ),
                                'delete' => array(
                                    'url'       => 'Yii::app()->createUrl("administrador/menu/deleteitem", array("id"=>$data->id))',
                                    'visible'   => '(Yii::app()->user->checkAccess("eliminar_menu_item"))?true:false', 
                                    'imageUrl' => false,
                                    'label' => '<i class="fa fa-trash-o"></i>', 
                                    'options'  => array('title' => 'Eliminar'), 
                                ),
                            ),
                        ),
                    )
                )); ?>
                <?php endif; ?>
                <?php endif ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="col-sm-12">
        <div class="nav navbar-right btn-group">
            <?php echo (Yii::app()->user->checkAccess('crear_menus')) ? l('<i class="fa fa-plus"></i> Cree un menú', $this->createUrl('menu/crear', array('id' => $model->id)), array('class' => 'btn btn-primary')): ''?>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Asignación de menú</h3>
            </div>
            <div class="box-body">
                <div class="alert alert-info alert-dismissable">
                    <i class="fa fa-info"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <b>¡Pilas!</b> Este micrositio no tiene un menú asignado.
                </div>
                <?php if(Yii::app()->user->checkAccess('asignar_menu_'.strtolower($this->ID)) || Yii::app()->user->checkAccess('asignar_menus') ): ?>
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
            </div>
        </div>
    </div>
    <?php endif ?>
<?php endif; ?>
</div>
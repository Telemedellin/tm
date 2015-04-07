<div class="row">
<?php if($menu): ?>
    <?php if(Yii::app()->user->checkAccess('crear_menu_item')): ?>
    <div class="col-sm-12">
        <div class="nav navbar-right">
            <?php echo l('<i class="fa fa-plus"></i> Agregar item de galería', $this->createUrl('menu/crearitemajax', array('id' => $model->menu_id)), array('class' => 'btn btn-default'))?>
            <?php echo l('<i class="fa fa-plus"></i> Agregar item de menú', $this->createUrl('menu/crearitem', array('id' => $model->menu_id)), array('class' => 'btn btn-primary'))?>
        </div>
    </div>
    <?php endif ?>
    <div class="col-sm-12">
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
<?php else: ?>
    <div class="col-sm-12">
        <!--<div class="nav navbar-right btn-group">
            <?php echo (Yii::app()->user->checkAccess('crear_menus')) ? l('<i class="fa fa-plus"></i> Cree un menú', $this->createUrl('menu/crear', array('id' => $model->id)), array('class' => 'btn btn-primary')): ''?>
        </div>-->
        <p>No hay menú asignado</p>
    </div>
<?php endif; ?>
</div>
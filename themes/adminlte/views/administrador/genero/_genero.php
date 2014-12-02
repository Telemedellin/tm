<div class="row">
    <?php if(Yii::app()->user->checkAccess('asignar_generos')): ?>
    <div class="col-sm-12">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id'=>'url-form',
            'action' => $this->createUrl('genero/asignar'), 
            'enableAjaxValidation'=>false,
            'htmlOptions' => array( 
                'role' => 'form',
            )
        )); 
        $mxg = new MicrositioXGenero;?>
        <div class="nav navbar-right input-group col-sm-12">
            <?php echo $form->hiddenField($mxg, 'micrositio_id', array('value' => $model->id) ); ?>
            <?php echo $form->dropDownList($mxg, 'genero_id', CHtml::listData(Genero::model()->getGeneros($model->id), 'id', 'nombre'), array('class' => 'form-control') ); ?>
            <span class="input-group-btn">
                <?php echo CHtml::submitButton('Asignar +', array('class' => 'btn btn-primary btn-block')); ?>
            </span>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <?php endif ?>
    <?php if($generos->getData()): ?>
    <div class="col-sm-12">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'            => 'genero-grid', 
    	'dataProvider'  => $generos,
        'enableSorting' => true,
        'pager'         => array('pageSize' => 25),
        'htmlOptions'   => array('style' => 'clear:both;'), 
        'columns'       => array(
            'genero.nombre',
            array(
                'class'=>'CButtonColumn',
                'template'  => '{delete}',
                'buttons'   => array(
                    'delete' => array(
                        'url'       => 'Yii::app()->createUrl("administrador/genero/desasignar", array("id"=>$data->id))',
                        'visible'   => '(Yii::app()->user->checkAccess("desasignar_generos"))?true:false', 
                        'imageUrl' => false,
                        'label' => '<i class="fa fa-times"></i>', 
                        'options'  => array('title' => 'Desasignar'),
                    ),
                ),
                'htmlOptions' => array('width'=>'40px'),
            ),
        )
    )); ?>
    </div>
    <?php endif; ?>
</div>
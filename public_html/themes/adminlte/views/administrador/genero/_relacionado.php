<?php
//Yii::app()->clientScript->registerScriptFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCoreScript('jquery.ui', CClientScript::POS_END);
$str_js = "
        var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        };
 
        $('#relacionado-grid table tbody').sortable({
            forcePlaceholderSize: true,
            forceHelperSize: true,
            items: 'tr',
            update : function () {
                serial = $('#relacionado-grid table tbody').sortable('serialize', {key: 'items[]', attribute: 'class'}); /******* PILAS ********/
                $.ajax({
                    'url': '" . $this->createUrl('relacionado/sort') . "',
                    'type': 'post',
                    'data': serial,
                    'success': function(data){
                    },
                    'error': function(request, status, error){
                        alert('We are unable to set the sort order at this time.  Please try again in a few minutes.');
                    }
                });
            },
            helper: fixHelper
        }).disableSelection();
    ";
 
    Yii::app()->clientScript->registerScript('sortable-relacionado', $str_js);
?>
<div class="row">
    <?php if(Yii::app()->user->checkAccess('asignar_relacionados')): ?>
    <div class="col-sm-12">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id'=>'url-form',
            'action' => $this->createUrl('relacionado/asignar'), 
            'enableAjaxValidation'=>false,
            'htmlOptions' => array( 
                'role' => 'form',
            )
        )); 
        $mxr = new MicrositioXRelacionado;?>
        <div class="nav navbar-right input-group col-sm-12">
            <?php echo $form->hiddenField($mxr, 'micrositio_id', array('value' => $model->id) ); ?>
            <?php echo $form->dropDownList($mxr,'relacionado_id', CHtml::listData(Micrositio::model()->findAll(array('order' => 'nombre ASC')), 'id', 'nombre'), array('class' => 'form-control chosen', 'required' => true) ); ?>
            <span class="input-group-btn">
                <?php echo CHtml::submitButton('Asignar +', array('class' => 'btn btn-primary btn-block')); ?>
            </span>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <?php endif ?>
    <?php if($relacionados->getData()): ?>
    <div class="col-sm-12">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
    	'id'            => 'relacionado-grid', 
        'dataProvider'  => $relacionados,
        'enableSorting' => true,
        'pager'         => array('pageSize' => 25),
        'htmlOptions'   => array('style' => 'clear:both;'), 
        'rowCssClassExpression'=>'"items[]_{$data->id}"',
        'columns'       => array(
            array(
                'type' => 'raw', 
                'header' => '<i class="fa fa-sort-amount-asc"></i>',
                'value' => '"<i class=\"fa fa-sort\"></i>"', 
                'htmlOptions' => array('class'=>'sort'),
            ),
            'relacionado.nombre',
            array(
                'class'=>'CButtonColumn',
                'template'  => '{delete}',
                'buttons'   => array(
                    'delete' => array(
                        'url'       => 'Yii::app()->createUrl("administrador/relacionado/desasignar", array("id"=>$data->id))', 
                        'visible'   => '(Yii::app()->user->checkAccess("desasignar_relacionados"))?true:false', 
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
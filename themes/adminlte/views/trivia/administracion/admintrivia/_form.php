<?php
cs()->coreScriptPosition = CClientScript::POS_END;
cs()->registerCoreScript( 'jquery.ui' );
Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
cs()->registerScriptFile(bu('js/libs/admin/jquery-ui-timepicker-addon.js'), CClientScript::POS_END);
cs()->registerScriptFile(bu('js/libs/admin/i18n/jquery.ui.timepicker-es.js'), CClientScript::POS_END);
Yii::app()->clientScript->registerScript('timepicker', 
    'var startDateTextBox = $(".fecha_inicio"),
         endDateTextBox = $(".fecha_fin");
    startDateTextBox.datetimepicker(
        {
            dateFormat: "yy-mm-dd",
            timeFormat: "H:mm:ss",
            minuteGrid: 10,
            onClose: function(dateText, inst) {
                if (endDateTextBox.val() != "") {
                    var testStartDate = startDateTextBox.datetimepicker("getDate");
                    var testEndDate = endDateTextBox.datetimepicker("getDate");
                    if (testStartDate > testEndDate)
                        endDateTextBox.datetimepicker("setDate", testStartDate);
                }
                else {
                    endDateTextBox.val(dateText);
                }
            },
            onSelect: function (selectedDateTime){
                endDateTextBox.datetimepicker("option", "minDate", startDateTextBox.datetimepicker("getDate") );
            }
        }, 
        $.datepicker.regional[ "es" ]
    );
    endDateTextBox.datetimepicker(
        { 
           dateFormat: "yy-mm-dd",
           timeFormat: "H:mm:ss",
            minuteGrid: 10,
            onClose: function(dateText, inst) {
                if (startDateTextBox.val() != "") {
                    var testStartDate = startDateTextBox.datetimepicker("getDate");
                    var testEndDate = endDateTextBox.datetimepicker("getDate");
                    console.log("s " + testStartDate + " e " + testEndDate);
                    if (testStartDate > testEndDate)
                        startDateTextBox.datetimepicker("setDate", testEndDate);
                }
                else {
                    startDateTextBox.val(dateText);
                }
            }
        },
        $.datepicker.regional[ "es" ]
    );', 
    CClientScript::POS_READY);
?>
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'url-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data', 
        'role' => 'form', 
    )
)); ?>
<?php $this->renderPartial('//layouts/commons/_form_error_summary', array('form' => $form, 'model' => $model)); ?>
<div class="row">
    <div class="col-sm-8">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Configuración</h3>
            </div>
            <div class="box-body">
            	<div class="form-group">
            		<?php echo $form->label($model,'fecha_inicio'); ?>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            		  <?php echo $form->textField($model, 'fecha_inicio', array('class' => 'form-control fecha_inicio')); ?>
                    </div>
                    <?php echo $form->error($model,'fecha_inicio'); ?>
            	</div>
            	<div class="form-group">
            		<?php echo $form->label($model,'fecha_fin'); ?>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            		  <?php echo $form->textField($model, 'fecha_fin', array('class' => 'form-control fecha_fin')); ?>
                    </div>
                    <?php echo $form->error($model,'fecha_fin'); ?>
            	</div>
               <div class="form-group">
            		<?php echo $form->label($model,'puntos'); ?>
            		<?php echo $form->numberField($model, 'puntos', array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
                    <?php echo $form->error($model,'puntos'); ?>
            	</div>
            </div>
        </div>
    </div><!-- ./col-sm-8 -->
    <div class="col-sm-4">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Opciones</h3>
            </div>
            <div class="box-body">
            	<div class="form-group">
            		<?php echo $form->label($model,'estado'); ?>
            		<?php echo $form->dropDownList($model, 'estado', array(1 => 'Activada', 0 => 'Desactivada' ), array('class' => 'form-control')); ?>	
            	</div>
            	<div class="form-group buttons">
            		<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary')); ?>
            	</div>
            </div>
        </div>
    </div><!-- ./col-sm-4 -->
</div><!-- ./row -->
<?php $this->endWidget(); ?>
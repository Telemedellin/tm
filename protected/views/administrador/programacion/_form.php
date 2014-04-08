<?php
cs()->coreScriptPosition = CClientScript::POS_END;
cs()->registerCoreScript( 'jquery.ui' );
Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
cs()->registerScriptFile(bu('js/libs/admin/i18n/jquery.ui.datepicker-es.js'), CClientScript::POS_END);
cs()->registerScriptFile(bu('js/libs/admin/jquery-ui-timepicker-addon.js'), CClientScript::POS_END);
Yii::app()->clientScript->registerScript('datepicker', 
    'var startDateTextBox = $(".hora_inicio"),
         endDateTextBox = $(".hora_fin");
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
<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'url-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
            'role' => 'form',
            'class' => 'form-horizontal' 
    )
)); ?>
	<?php echo $form->errorSummary($model); ?>
	<div class="form-group">
		<?php echo $form->label($model,'micrositio_id', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-5">
            <?php echo $form->dropDownList($model,'micrositio_id', CHtml::listData(Micrositio::model()->findAll('seccion_id = 2 OR seccion_id = 3 OR seccion_id = 4'), 'id', 'nombre'), array('class' => 'form-control chosen') ); ?>
            <?php /*$this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                'name'=>'micrositio',
                'sourceUrl' => bu('api/micrositios'), 
                'value' => $model->micrositio->nombre, 
                'options'=>array(
                    'minLength'=>'2',
                    'delay'=>'0',
                    'select' => new CJavaScriptExpression('function( event, ui ) {
                        $( "#Programacion_micrositio_id" ).val( ui.item.id );
                    }'),
                    'change' => new CJavaScriptExpression('function( event, ui ) {
                        $( "#Programacion_micrositio_id" ).attr( "value", "" );
                    }'),
                ),
                'htmlOptions'=>array(
                    'class'=>'form-control',
                ),
            ));*/
            echo $form->hiddenField($model, 'micrositio_id');
            ?>
        </div>
		<?php echo $form->error($model,'micrositio_id'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'hora_inicio', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-2">
            <input name="Programacion[hora_inicio]" type="text" value="<?php echo ($model->hora_inicio)?date('Y-m-d G:i:s', $model->hora_inicio):'' ?>" class="hora_inicio form-control" />
        </div>
		<?php echo $form->error($model,'hora_inicio'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'hora_fin', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-2">
            <input name="Programacion[hora_fin]" type="text" value="<?php echo ($model->hora_fin)?date('Y-m-d G:i:s', $model->hora_fin):'' ?>" class="hora_fin form-control" />
        </div>
		<?php echo $form->error($model,'hora_fin'); ?>
	</div>
    <div class="form-group">
        <?php echo $form->label($model,'tipo_emision_id', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-2">
            <?php echo $form->dropDownList($model,'tipo_emision_id', CHtml::listData(TipoEmision::model()->findAll(), 'id', 'nombre'), array('options' => array( '5' =>array('selected'=>true)), 'class' => 'form-control') ); ?>
        </div>
        <?php echo $form->error($model,'tipo_emision_id'); ?>
    </div>
	<div class="form-group">
		<?php echo $form->label($model,'estado', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-2">
            <?php echo $form->dropDownList($model, 'estado', array('1' => 'Si', '0' => 'No' ), array('class' => 'form-control')); ?>
        </div>
		<?php echo $form->error($model,'estado'); ?>
	</div>
	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
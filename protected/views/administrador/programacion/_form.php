<?php
cs()->coreScriptPosition = CClientScript::POS_END;
cs()->registerCoreScript( 'jquery.ui' );
Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
cs()->registerScriptFile('js/libs/admin/i18n/jquery.ui.datepicker-es.js', CClientScript::POS_END);
cs()->registerScriptFile('js/libs/admin/jquery-ui-timepicker-addon.js', CClientScript::POS_END);
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
                    if (testStartDate > testEndDate)
                        startDateTextBox.datetimepicker("setDate", testEndDate);
                }
                else {
                    startDateTextBox.val(dateText);
                }
            },
            onSelect: function (selectedDateTime){
                startDateTextBox.datetimepicker("option", "maxDate", endDateTextBox.datetimepicker("getDate") );
            }
        },
        $.datepicker.regional[ "es" ]
    );', 
    CClientScript::POS_READY);
?>
<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'url-form',
	'enableAjaxValidation'=>false
)); ?>
	<?php echo $form->errorSummary($model); ?>
	<div class="form-group">
		<?php echo $form->labelEx($model,'micrositio_id'); ?>
        <?php echo $form->dropDownList($model,'micrositio_id', CHtml::listData(Micrositio::model()->findAll(), 'id', 'nombre') ); ?>
		<?php echo $form->error($model,'micrositio_id'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->labelEx($model,'hora_inicio'); ?>
        <input name="Programacion[hora_inicio]" type="text" value="<?php echo ($model->hora_inicio)?date('Y-m-d H:i:s', $model->hora_inicio):'' ?>" class="hora_inicio" />
		<?php echo $form->error($model,'hora_inicio'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->labelEx($model,'hora_fin'); ?>
		<input name="Programacion[hora_fin]" type="text" value="<?php echo ($model->hora_fin)?date('Y-m-d H:i:s', $model->hora_fin):'' ?>" class="hora_fin" />
		<?php echo $form->error($model,'hora_fin'); ?>
	</div>
    <div class="form-group">
        <?php echo $form->labelEx($model,'tipo_emision_id'); ?>
        <?php echo $form->dropDownList($model,'tipo_emision_id', CHtml::listData(TipoEmision::model()->findAll(), 'id', 'nombre'), array('options' => array( '5' =>array('selected'=>true))) ); ?>
        <?php echo $form->error($model,'tipo_emision_id'); ?>
    </div>
	<div class="form-group">
		<?php echo $form->labelEx($model,'estado'); ?>
		<?php echo $form->dropDownList($model, 'estado', array('1' => 'Si', '0' => 'No' )); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>
	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Guardar'); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
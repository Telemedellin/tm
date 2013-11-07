<?php
cs()->coreScriptPosition = CClientScript::POS_END;
cs()->registerCoreScript( 'jquery.ui' );
Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
cs()->registerScriptFile(bu('js/libs/admin/jquery-ui-timepicker-addon.js'), CClientScript::POS_END);
cs()->registerScriptFile(bu('js/libs/admin/i18n/jquery.ui.timepicker-es.js'), CClientScript::POS_END);
Yii::app()->clientScript->registerScript('timepicker', 
    'var startDateTextBox = $(".hora_inicio"),
         endDateTextBox = $(".hora_fin");
    $.timepicker.setDefaults($.timepicker.regional["es"]);
    startDateTextBox.timepicker(
        {
            timeFormat: "h:mm tt",
            timeOnly: true, 
            amNames: ["AM", "A"],
            pmNames: ["PM", "P"],
            minuteGrid: 10,
            onClose: function(dateText, inst) {
                if (endDateTextBox.val() != "") {
                    var testStartDate = startDateTextBox.datepicker("getDate");
                    var testEndDate = endDateTextBox.datepicker("getDate");
                    console.log(testEndDate);
                    if (testStartDate > testEndDate)
                        endDateTextBox.timepicker("setDate", testStartDate);
                }
                else {
                    endDateTextBox.val(dateText);
                }
            },
            onSelect: function (selectedDateTime){
                endDateTextBox.timepicker("option", "minDate", startDateTextBox.datepicker("getDate") );
            }
        }        
    );
	
    endDateTextBox.timepicker(
        { 
           timeFormat: "h:mm tt",
           timeOnly: true, 
            amNames: ["AM", "A"],
            pmNames: ["PM", "P"],
            minuteGrid: 10,
            onClose: function(dateText, inst) {
                if (startDateTextBox.val() != "") {
                    var testStartDate = startDateTextBox.datepicker("getDate");
                    var testEndDate = endDateTextBox.datepicker("getDate");
                    if (testStartDate > testEndDate)
                        startDateTextBox.timepicker("setDate", testEndDate);
                }
                else {
                    startDateTextBox.val(dateText);
                }
            },
            onSelect: function (selectedDateTime){
                startDateTextBox.timepicker("option", "maxDate", endDateTextBox.datepicker("getDate") );
            }
        }
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
        <?php echo $form->label($model,'pg_programa_id', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-4">
        <?php echo $form->dropDownList($model, 'pg_programa_id', CHtml::listData(PgPrograma::model()->with('pagina')->findAll(), 'id', 'pagina.nombre'), array('class' => 'form-control') ); ?>
        </div>
        <?php echo $form->error($model,'pg_programa_id'); ?>
    </div>
    <div class="form-group">
		<?php echo $form->label($model,'hora_inicio', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-4">
            <input name="Horario[hora_inicio]" type="text" value="<?php echo ($model->hora_inicio)?Horarios::hora($model->hora_inicio, true):'' ?>" class="hora_inicio form-control" />
        </div>
		<?php echo $form->error($model,'hora_inicio'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'hora_fin', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-4">
            <input name="Horario[hora_fin]" type="text" value="<?php echo ($model->hora_fin)?Horarios::hora($model->hora_fin, true):'' ?>" class="hora_fin form-control" />
        </div>
		<?php echo $form->error($model,'hora_fin'); ?>
	</div>
	<div class="form-group">
        <?php echo $form->label($model,'tipo_emision_id', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-4">
            <?php echo $form->dropDownList($model,'tipo_emision_id', CHtml::listData(TipoEmision::model()->findAll(), 'id', 'nombre'), array( 'class' => 'form-control') ); ?>
        </div>
        <?php echo $form->error($model,'tipo_emision_id'); ?>
    </div>
	<div class="form-group">
		<?php echo $form->label($model,'estado', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-4">
            <?php echo $form->dropDownList($model, 'estado', array('1' => 'Si', '0' => 'No' ), array('class' => 'form-control')); ?>
        </div>
		<?php echo $form->error($model,'estado'); ?>
	</div>
	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary')); ?>
	</div>
	<input type="hidden" value="<?php echo Yii::app()->request->baseUrl ?>" id="PUBLIC_PATH"/>
<?php $this->endWidget(); ?>
</div><!-- form -->
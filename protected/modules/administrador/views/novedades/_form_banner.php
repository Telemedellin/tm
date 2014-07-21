<?php
cs()->coreScriptPosition = CClientScript::POS_END;
cs()->registerCoreScript( 'jquery.ui' );
Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
cs()->registerScriptFile(bu('js/libs/admin/i18n/jquery.ui.datepicker-es.js'), CClientScript::POS_END);
cs()->registerScriptFile(bu('js/libs/admin/jquery-ui-timepicker-addon.js'), CClientScript::POS_END);
Yii::app()->clientScript->registerScript('datepicker', 
    'var startDateTextBox = $(".inicio_publicacion"),
         endContadorTextBox = $(".fin_contador"),
         endDateTextBox = $(".fin_publicacion");
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
            }
        },
        $.datepicker.regional[ "es" ]
    );
    endContadorTextBox.datetimepicker(
        {
            dateFormat: "yy-mm-dd",
            timeFormat: "H:mm:ss",
            minuteGrid: 10,
        }, 
        $.datepicker.regional[ "es" ]
    );
    $("#Banner_contador").change(function(){
        check_contador();
    });
    check_contador();
    function check_contador()
    {
        if($("#Banner_contador").val() == 1)
            endContadorTextBox.attr("required", true);
        else
            endContadorTextBox.removeAttr("required");
    }
    ', 
    CClientScript::POS_READY);
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'banner-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
        'role' => 'form',
        'class' => 'form-horizontal' 
    )
)); ?>
	<?php echo $form->errorSummary( $model ); ?>
	<div class="form-group">
		<?php echo $form->label($model,'nombre', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-6">
			<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
		</div>
		<?php echo $form->error($model,'nombre'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'url', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-6">
			<?php echo $form->urlField($model,'url',array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
		</div>
		<?php echo $form->error($model,'url'); ?>
	</div>
	<div class="form-group">
        <?php echo $this->imageField($form, $model, 'imagen', 'archivoImagen', '_banner'); ?>
        <span class="help-block">Alto máximo: 150 px, Ancho máximo: 390px</span>
	</div>
    <div class="form-group">
        <?php echo $this->imageField($form, $model, 'imagen_mobile', 'archivoImagenMobile', '_banner'); ?>
        <span class="help-block"> Alto máximo: 400 px, Ancho máximo: 650px</span>
    </div>
    <div class="form-group">
        <?php echo $form->label($model,'contador', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-2">
            <?php echo $form->dropDownList($model,'contador', array('1' => 'Activado', '0' => 'Desactivado' ), array('class' => 'form-control') ); ?>
        </div>
        <?php echo $form->error($model,'contador'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label($model,'fin_contador', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-2">
            <input name="Banner[fin_contador]" type="text" value="<?php echo $model->fin_contador ?>" class="fin_contador form-control" />
        </div>
        <?php echo $form->error($model,'fin_contador'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label($model,'fuente', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
            <?php echo $form->dropDownList($model,'fuente', 
            array(
                'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif', 
                "Comic Sans MS', cursive" => "Comic Sans MS', cursive",
                "'Courier New', Courier, monospace" => "'Courier New', Courier, monospace",
                "Garamond, serif" => "Garamond, serif",
                "Georgia, serif" => "Georgia, serif",
                "Impact, Charcoal, sans-serif" => "Impact, Charcoal, sans-serif",
                "Consolas, 'Lucida Console', Monaco, monospace",
                "'Lucida Sans Unicode', 'Lucida Grande', sans-serif" => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
                "Tahoma, Geneva, sans-serif" => "Tahoma, Geneva, sans-serif",
                "'Times New Roman', Times, serif" => "'Times New Roman', Times, serif",
                "'Trebuchet MS', Helvetica, sans-serif" => "'Trebuchet MS', Helvetica, sans-serif",
                ), 
            array('class' => 'form-control', 'placeholder' => 'Arial, Helvetica, sans-serif')); ?>
        </div>
        <?php echo $form->error($model,'fuente'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label($model,'tamano', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
            <?php echo $form->numberField($model,'tamano',array('size'=>60, 'min'=>9, 'max' => 30, 'class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($model,'tamano'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label($model,'color', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
            <?php echo $form->textField($model,'color',array('size'=>60,'maxlength'=>7, 'class' => 'form-control', 'placeholder' => '#000000')); ?>
        </div>
        <?php echo $form->error($model,'color'); ?>
    </div>
    <div class="form-group">
		<?php echo $form->label($model,'inicio_publicacion', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-2">
            <input name="Banner[inicio_publicacion]" type="text" value="<?php echo $model->inicio_publicacion ?>" class="inicio_publicacion form-control" />
        </div>
		<?php echo $form->error($model,'inicio_publicacion'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'fin_publicacion', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-2">
            <input name="Banner[fin_publicacion]" type="text" value="<?php echo $model->fin_publicacion ?>" class="fin_publicacion form-control" />
        </div>
		<?php echo $form->error($model,'fin_publicacion'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'estado', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-2">
			<?php echo $form->dropDownList($model,'estado', array('1' => 'Si', '0' => 'No' ), array('class' => 'form-control') ); ?>
		</div>
		<?php echo $form->error($model,'estado'); ?>
	</div>
	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary')); ?>
	</div>
	<input type="hidden" value="<?php echo Yii::app()->request->baseUrl ?>" id="PUBLIC_PATH"/>
<?php $this->endWidget(); ?>
</div><!-- form -->
<?php echo $this->renderPartial('../_file_upload_tmpl') ?>
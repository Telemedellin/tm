<?php
cs()->coreScriptPosition = CClientScript::POS_END;
cs()->registerCoreScript( 'jquery.ui' );
Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
cs()->registerScriptFile(bu('js/libs/admin/i18n/jquery.ui.datepicker-es.js'), CClientScript::POS_END);
cs()->registerScriptFile(bu('js/libs/admin/jquery-ui-timepicker-addon.js'), CClientScript::POS_END);
Yii::app()->clientScript->registerScript('datepicker', 
    'var startDateTextBox = $(".inicio_publicacion"),
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
    ', 
    CClientScript::POS_READY);
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'guino-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
        'role' => 'form',
    )
)); ?>
<?php $this->renderPartial('//layouts/commons/_form_error_summary', array('form' => $form, 'model' => $model)); ?>
<div class="row">
    <div class="col-sm-8">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Contenido</h3>
            </div>
            <div class="box-body">
                <div class="form-group">
            		<?php echo $form->label($model,'nombre'); ?>
            		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
            		<?php echo $form->error($model,'nombre'); ?>
            	</div>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Imágenes</h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $this->imageField($form, $model, 'guino', 'archivoImagen', '_guino'); ?>
                    <span class="help-block">Alto máximo: 100 px, Ancho máximo: 250px</span>
            	</div>
                <div class="form-group">
                    <?php echo $this->imageField($form, $model, 'guino_mobile', 'archivoImagenMobile', '_guino'); ?>
                    <span class="help-block"> Alto máximo: 74 px, Ancho máximo: 186px</span>
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
            		<?php echo $form->label($model,'inicio_publicacion'); ?>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input name="Guino[inicio_publicacion]" type="text" value="<?php echo $model->inicio_publicacion ?>" class="inicio_publicacion form-control" />
                    </div>
            		<?php echo $form->error($model,'inicio_publicacion'); ?>
            	</div>
            	<div class="form-group">
            		<?php echo $form->label($model,'fin_publicacion'); ?>
            		<div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input name="Guino[fin_publicacion]" type="text" value="<?php echo $model->fin_publicacion ?>" class="fin_publicacion form-control" />
                    </div>
            		<?php echo $form->error($model,'fin_publicacion'); ?>
            	</div>
            	<div class="form-group">
            		<?php echo $form->label($model,'estado'); ?>
            		<div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-eye"></i></span>
            			<?php echo $form->dropDownList($model,'estado', array('1' => 'Sí', '0' => 'No' ), array('class' => 'form-control') ); ?>
            		</div>
            		<?php echo $form->error($model,'estado'); ?>
            	</div>
            	<div class="form-group buttons">
                    <?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary btn-block')); ?>
                </div>
                <input type="hidden" value="<?php echo Yii::app()->request->baseUrl ?>" id="PUBLIC_PATH"/>
            </div>
        </div>
    </div><!-- ./col-sm-4 -->
</div><!-- ./row -->
<?php $this->endWidget(); ?>
<?php echo $this->renderPartial('//layouts/commons/_file_upload_tmpl') ?>
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
            }
        }
    );', 
    CClientScript::POS_READY);
?>
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'url-form',
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
			        <?php echo $form->label($model,'pg_programa_id'); ?>
			        <?php echo $form->dropDownList($model, 'pg_programa_id', CHtml::listData(PgPrograma::model()->with('pagina')->findAll(), 'id', 'pagina.nombre'), array('class' => 'form-control', 'required' => true) ); ?>
			        <?php echo $form->error($model,'pg_programa_id'); ?>
			    </div>
			    <div class="form-group">
			        <?php echo $form->label($model,'dia_semana'); ?>
			        <?php echo $form->dropDownList($model, 'dia_semana', 
			                                                        array(
			                                                            '1' => 'Lunes', 
			                                                            '2' => 'Martes', 
			                                                            '3' => 'Miércoles', 
			                                                            '4' => 'Jueves', 
			                                                            '5' => 'Viernes', 
			                                                            '6' => 'Sábado', 
			                                                            '7' => 'Domingo', 
			                                                            ), 
			                                                        array('class' => 'form-control', 'required' => true)
			                                                    ); ?>
			        <?php echo $form->error($model,'dia_semana'); ?>
			    </div>
			    <div class="form-group">
					<?php echo $form->label($model,'hora_inicio'); ?>
			        <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
			            <input name="Horario[hora_inicio]" type="text" value="<?php echo ($model->hora_inicio)?Horarios::hora($model->hora_inicio, true):'' ?>" class="hora_inicio form-control" required />
			        </div>
					<?php echo $form->error($model,'hora_inicio'); ?>
				</div>
				<div class="form-group">
					<?php echo $form->label($model,'hora_fin'); ?>
					<div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
			            <input name="Horario[hora_fin]" type="text" value="<?php echo ($model->hora_fin)?Horarios::hora($model->hora_fin, true):'' ?>" class="hora_fin form-control" required />
			        </div>
					<?php echo $form->error($model,'hora_fin'); ?>
				</div>
				<div class="form-group">
			        <?php echo $form->label($model,'tipo_emision_id'); ?>
			        <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-rss"></i></span>
			            <?php echo $form->dropDownList($model,'tipo_emision_id', CHtml::listData(TipoEmision::model()->findAll(), 'id', 'nombre'), array( 'class' => 'form-control', 'required' => true) ); ?>
			        </div>
			        <?php echo $form->error($model,'tipo_emision_id'); ?>
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
					<div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-eye"></i></span>
			            <?php echo $form->dropDownList($model, 'estado', array('1' => 'Si', '0' => 'No' ), array('class' => 'form-control', 'required' => true)); ?>
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
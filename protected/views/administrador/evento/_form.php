<?php
cs()->coreScriptPosition = CClientScript::POS_END;
cs()->registerCoreScript( 'jquery.ui' );
Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
cs()->registerScriptFile(bu('js/libs/admin/i18n/jquery.ui.datepicker-es.js'), CClientScript::POS_END);
cs()->registerScriptFile(bu('js/libs/admin/jquery-ui-timepicker-addon.js'), CClientScript::POS_END);
Yii::app()->clientScript->registerScript('datepicker', 
    'var dateTextBox = $(".fecha"),
         hourTextBox = $(".hora");
    dateTextBox.datepicker(
        {
            dateFormat: "yy-mm-dd",
        }, 
        $.datepicker.regional[ "es" ]
    );
    hourTextBox.datetimepicker(
        { 
            dateFormat: "yy-mm-dd",
            timeFormat: "H:mm:ss",
            minuteGrid: 10,
            timeOnly: true, 
        },
        $.datepicker.regional[ "es" ]
    );', 
    CClientScript::POS_READY);
?>
<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'evento-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'role' => 'form',
        'class' => 'form-horizontal' 
    )
)); ?>
	<?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->label($model,'pg_eventos_id', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
            <?php echo $form->dropDownList($model, 'pg_eventos_id', CHtml::listData(PgEventos::model()->findAll('id = '.$model->pg_eventos_id), 'id', 'pagina.nombre'), array('class' => 'form-control') ); ?>
        </div>
        <?php echo $form->error($model,'pg_eventos_id'); ?>
    </div>
	<div class="form-group">
		<?php echo $form->label($model,'nombre', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-6">
            <?php echo $form->textField($model, 'nombre', array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
        </div>
		<?php echo $form->error($model,'nombre'); ?>
	</div>
    <div class="form-group">
        <?php echo $form->label($model,'fecha', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-2">
            <input name="Evento[fecha]" type="text" value="<?php echo ($model->fecha)?date('Y-m-d', $model->fecha):'' ?>" class="fecha form-control" />
        </div>
        <?php echo $form->error($model,'fecha'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label($model,'hora', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-2">
            <input name="Evento[hora]" type="text" value="<?php echo ($model->hora)?date('G:i', $model->hora):'' ?>" class="hora form-control" />
        </div>
        <?php echo $form->error($model,'hora'); ?>
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
    <?php echo CHtml::hiddenField('returnURL', Yii::app()->request->urlReferrer); ?>
<?php $this->endWidget(); ?>
</div><!-- form -->
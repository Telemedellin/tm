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
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'evento-form',
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
			        <?php echo $form->label($model,'pg_eventos_id'); ?>
			        <?php echo $form->dropDownList($model, 'pg_eventos_id', CHtml::listData(PgEventos::model()->findAll('id = '.$model->pg_eventos_id), 'id', 'pagina.nombre'), array('class' => 'form-control', 'required' => true) ); ?>
			        <?php echo $form->error($model,'pg_eventos_id'); ?>
			    </div>
				<div class="form-group">
					<?php echo $form->label($model,'nombre'); ?>
					<?php echo $form->textField($model, 'nombre', array('size'=>60,'maxlength'=>255, 'class' => 'form-control', 'required' => true)); ?>
			        <?php echo $form->error($model,'nombre'); ?>
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
			        <?php echo $form->label($model,'fecha'); ?>
			        <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			            <input name="Evento[fecha]" type="text" value="<?php echo ($model->fecha)?date('Y-m-d', $model->fecha):'' ?>" class="fecha form-control" required />
			        </div>
			        <?php echo $form->error($model,'fecha'); ?>
			    </div>
			    <div class="form-group">
			        <?php echo $form->label($model,'hora'); ?>
			        <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
			            <input name="Evento[hora]" type="text" value="<?php echo ($model->hora)?date('G:i', $model->hora):'' ?>" class="hora form-control" required />
			        </div>
			        <?php echo $form->error($model,'hora'); ?>
			    </div>
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
			    <?php echo CHtml::hiddenField('returnURL', Yii::app()->request->urlReferrer); ?>
			</div>
		</div>
    </div><!-- ./col-sm-4 -->
</div><!-- ./row -->
<?php $this->endWidget(); ?>
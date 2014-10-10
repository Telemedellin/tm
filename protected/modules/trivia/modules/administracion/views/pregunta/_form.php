<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'url-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data', 
        'role' => 'form',
        'class' => 'form-horizontal' 
    )
)); ?>
	<?php echo $form->errorSummary($model); ?>
	<div class="form-group">
		<?php echo $form->label($model,'pregunta', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
            <?php echo $form->textField($model, 'pregunta', array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
		</div>
        <?php echo $form->error($model,'pregunta'); ?>
	</div>
    <?php foreach($model->respuestas_f as $r): ?>
        <?php $this->renderPartial('_respuesta', array('model' => $r)); ?>
    <?php endforeach ?>
	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pagina-form',
	'enableAjaxValidation'=>false,
)); ?>
	<?php echo $form->errorSummary($model); ?>
	<div class="form-group">
		<?php echo $form->label($model,'micrositio_id'); ?>
		<?php echo $form->dropDownList($model,'micrositio_id', CHtml::listData(Micrositio::model()->findAll(), 'id', 'nombre') ); ?>
		<?php echo $form->error($model,'micrositio_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->label($model,'estado'); ?>
		<?php echo $form->dropDownList($model,'estado', array('1' => 'Si', '0' => 'No' ) ); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->label($model,'destacado'); ?>
		<?php echo $form->dropDownList($model,'destacado', array('0' => 'No', '1' => 'Si' ) ); ?>
		<?php echo $form->error($model,'destacado'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->label($model,'tipo_pagina_id'); ?>
		<?php echo $form->dropDownList($model,'tipo_pagina_id', CHtml::listData(TipoPagina::model()->findAll(), 'id', 'nombre') ); ?>
		<?php echo $form->error($model,'tipo_pagina_id'); ?>
	</div>

	
	<div class="form-group buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
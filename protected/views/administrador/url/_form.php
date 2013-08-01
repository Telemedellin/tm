<?php
/* @var $this UrlController */
/* @var $model Url */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'url-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'slug'); ?>
		<?php echo $form->textField($model,'slug',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'slug'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tipo'); ?>
		<?php echo $form->dropDownList($model,'tipo',  array('1' => 'Sección', '2' => 'Micrositio', '3' => 'Página' )); ?>
		<?php echo $form->error($model,'tipo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'creado'); ?>
		<?php echo $form->textField($model,'creado',array('size'=>19,'maxlength'=>19)); ?>
		<?php echo $form->error($model,'creado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modificado'); ?>
		<?php echo $form->textField($model,'modificado',array('size'=>19,'maxlength'=>19)); ?>
		<?php echo $form->error($model,'modificado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'estado'); ?>
		<?php echo $form->textField($model,'estado'); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
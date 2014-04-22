<?php
/* @var $this MicrositioController */
/* @var $model Micrositio */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'micrositio-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'seccion_id'); ?>
		<?php echo $form->dropDownList($model,'seccion_id',CHtml::listData(Seccion::model()->findAll(), 'id', 'nombre')); ?>
		<?php echo $form->error($model,'seccion_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'menu_id'); ?>
		<?php echo $form->dropDownList($model,'menu_id',CHtml::listData(Menu::model()->findAll(), 'id', 'nombre'), array('empty'=>'Elija un menú si aplica')); ?>
		<?php echo $form->error($model,'menu_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url_id'); ?>
		<?php echo $form->dropDownList($model,'url_id',CHtml::listData(Url::model()->findAllByAttributes( array('tipo_id'=>2) ), 'id', 'slug')); ?>
		<?php echo $form->error($model,'url_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'background'); ?>
		<?php echo $form->fileField($model,'background'); ?>
		<?php echo $form->error($model,'background'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'estado'); ?>
		<?php echo $form->dropDownList($model,'estado', array('1' => 'Activo', '0' => 'Inactivo' )); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'destacado'); ?>
		<?php echo $form->dropDownList($model,'destacado', array('0' => 'No', '1' => 'Si' )); ?>
		<?php echo $form->error($model,'destacado'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
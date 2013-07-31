<?php
/* @var $this PaginaController */
/* @var $model Pagina */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'revision_id'); ?>
		<?php echo $form->textField($model,'revision_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'usuario_id'); ?>
		<?php echo $form->textField($model,'usuario_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'micrositio_id'); ?>
		<?php echo $form->textField($model,'micrositio_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo_pagina_id'); ?>
		<?php echo $form->textField($model,'tipo_pagina_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'url_id'); ?>
		<?php echo $form->textField($model,'url_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'creado'); ?>
		<?php echo $form->textField($model,'creado',array('size'=>19,'maxlength'=>19)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'modificado'); ?>
		<?php echo $form->textField($model,'modificado',array('size'=>19,'maxlength'=>19)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'estado'); ?>
		<?php echo $form->textField($model,'estado'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'destacado'); ?>
		<?php echo $form->textField($model,'destacado'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
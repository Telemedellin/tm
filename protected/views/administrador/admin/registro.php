<div id="content">
	<div id="titulo-registro">
		<h1>Registro</h1>
	</div>
	<div class="form">
	<?php 
	$activeform = $this->beginWidget('CActiveForm', array(
		'id'=>'registro-form',
		'enableAjaxValidation'=>true,
		'focus'=>array($usuario, 'correo'),
	));
	?>
	<?php echo $activeform->errorSummary($usuario, '', '', array('class' => 'flash-notice')); ?>

	<div class="row">
		<?php echo $activeform->label($usuario,'correo'); ?>
		<?php echo $activeform->emailField($usuario,'correo',array('size'=>60, 'maxlength'=>100)); ?> 
	</div>

	<div class="row">
		<?php echo $activeform->label($usuario,'password', array('label' => 'Contraseña <small> diferente a la de tu correo</small>') ); ?>
		<?php echo $activeform->passwordField($usuario,'password',array('size'=>60,'maxlength'=>255)); ?> 
	</div>
	<div class="row">
		<?php echo $activeform->label($usuario,'nombre'); ?>
		<?php echo $activeform->textField($usuario,'nombre',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons submit">
		<?php echo CHtml::submitButton('Registro', array('class'=>'btn')); ?>
	</div>

	<?php $this->endWidget(); ?>
	</div><!-- form -->
</div>

<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle= 'Registro - ' . Yii::app()->name;
?>
<div class="form login">
	<h1>Registro</h1>
	<?php 
	$activeform = $this->beginWidget('CActiveForm', array(
		'id'=>'registro-form',
		'enableAjaxValidation'=>true,
		'focus'=>array($usuario, 'correo'),
		'htmlOptions' => array(
			'role' => 'form', 
			'class' => 'form-horizontal', 
		)
	));
	?>
	<?php echo $activeform->errorSummary($usuario, '', '', array('class' => 'flash-notice')); ?>

	<div class="form-group">
		<?php echo $activeform->label($usuario,'correo', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-4">
			<?php echo $activeform->emailField($usuario,'correo', array('class' => 'form-control')); ?> 
		</div>
	</div>

	<div class="form-group">
		<?php echo $activeform->label($usuario,'password', array('class' => 'col-sm-2 control-label') ); ?>
		<div class="col-sm-4">
			<?php echo $activeform->passwordField($usuario,'password', array('class' => 'form-control')); ?> 
		</div>
	</div>
	<div class="form-group">
		<?php echo $activeform->label($usuario,'nombre', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-4">
			<?php echo $activeform->textField($usuario,'nombre', array('class' => 'form-control')); ?>
		</div>
	</div>

	<div class="form-group buttons submit">
		<?php echo CHtml::submitButton('Registro', array('class'=>'btn btn-default')); ?>
	</div>

	<?php $this->endWidget(); ?>
</div><!-- form -->
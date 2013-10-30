<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle= 'Ingresar - ' . Yii::app()->name;
?>

<div class="form login">
	<h1>Iniciar sesión</h1>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array(
			'role' => 'form', 
			'class' => 'form-horizontal', 
		)
)); ?>
	<?php echo $form->errorSummary($model, '', '', array('class' => 'flash-notice') ); ?>
	<div class="form-group">
		<?php echo $form->label($model,'correo', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-4">
		<?php echo $form->emailField($model,'correo', array('class' => 'form-control')); ?>
		</div>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'password', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-4">
		<?php echo $form->passwordField($model,'password', array('class' => 'form-control')); ?>
		</div>
	</div>
	<!--<div class="form-group rememberMe">
		<div class="checkbox">
			<?php echo $form->checkBox($model,'rememberMe'); ?>
			<?php echo $form->label($model,'rememberMe'); ?>
		</div>
	</div>-->
	<div class="form-group buttons">
		<div class="col-sm-offset-2 col-sm-4">
		<?php echo CHtml::submitButton('Ingresar', array('class' =>'btn btn-default')); ?>
		</div>
	</div>
	<div class="form-group">
		<?php echo CHtml::link('¿Olvidaste la contraseña?', array('administrador/recuperar-contrasena'), array('class' => 'recuperar' )); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
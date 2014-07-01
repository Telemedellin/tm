<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle= 'Ingresar - ' . Yii::app()->name;
?>

<div class="form login">
	<h1>Iniciar sesión</h1>
<?php if(Yii::app()->user->hasFlash('loginflash')): ?>
<div class="flash-error">
	<?php echo Yii::app()->user->getFlash('loginflash'); ?>
</div>
<?php else: ?>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'login-form',
		//'enableAjaxValidation'=>true,
		'enableClientValidation'=>false,
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
			<?php echo $form->label($model,'username', array('class' => 'col-sm-2 control-label')); ?>
			<div class="col-sm-4">
			<?php echo $form->emailField($model,'username', array('class' => 'form-control')); ?>
			</div>
			<?php echo $form->error($model,'username', array('class' => 'flash-notice')); ?>
		</div>
		<div class="form-group">
			<?php echo $form->label($model,'password', array('class' => 'col-sm-2 control-label')); ?>
			<div class="col-sm-4">
			<?php echo $form->passwordField($model,'password', array('class' => 'form-control')); ?>
			</div>
			<?php echo $form->error($model,'password', array('class' => 'flash-notice')); ?>
		</div>
		<div class="form-group rememberMe">
			<?php echo $form->label($model,'rememberMe', array('class' => 'col-sm-2 control-label')); ?>
			<?php echo $form->checkBox($model,'rememberMe'); ?>
			<?php echo $form->error($model,'rememberMe', array('class' => 'flash-notice')); ?>
		</div>
		<div class="form-group buttons">
			<div class="col-sm-offset-2 col-sm-4">
			<?php //echo CHtml::submitButton('Ingresar', array('class' =>'btn btn-default')); ?>
			<?php Yii::app()->user->ui->tbutton(CrugeTranslator::t('logon', "Login")); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo Yii::app()->user->ui->passwordRecoveryLink; ?>
			<?php
				if(Yii::app()->user->um->getDefaultSystem()->getn('registrationonlogin')===1)
					echo Yii::app()->user->ui->registrationLink;
			?>
		</div>
	<?php $this->endWidget(); ?>
<?php endif; ?>
</div><!-- form -->
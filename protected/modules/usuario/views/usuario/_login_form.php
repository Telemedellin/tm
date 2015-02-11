<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'action' => array('/usuario'), 
	'enableClientValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array(
			'role' => 'form', 
			'class' => 'form-horizontal', 
		)
)); ?>
	<?php if( $model->hasErrors() ) : ?>
		<div class="flash-notice error">
			<p>No se pudo iniciar sesión, por favor verifique los datos.</p>
		</div>
	<?php endif; ?>
	<div class="control-group">
		<?php echo $form->label($model,'username', array('class' => 'control-label')); ?>
		<div class="controls">
		<?php echo $form->emailField($model,'username'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label($model,'password', array('class' => 'control-label')); ?>
		<div class="controls">
		<?php echo $form->passwordField($model,'password'); ?>
		</div>
	</div>
	<div class="control-group buttons">
		<div class="controls">
		<?php //echo CHtml::submitButton('Ingresar', array('class' =>'btn btn-default')); ?>
		<?php Yii::app()->user->ui->tbutton(CrugeTranslator::t('logon', "Login")); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo l('No recuerdo mi contraseña', array('/usuario/recuperarclave')); ?>
		<?php if(Yii::app()->user->um->getDefaultSystem()->getn('registrationonlogin')===1)
			echo l('Regístrate', array('/usuario/registro'));
		?>
	</div>
<?php $this->endWidget(); ?>
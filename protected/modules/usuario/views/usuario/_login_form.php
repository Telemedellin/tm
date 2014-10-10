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
	<div class="form-group">
		<?php echo $form->label($model,'username', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-4">
		<?php echo $form->emailField($model,'username', array('class' => 'form-control')); ?>
		</div>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'password', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-4">
		<?php echo $form->passwordField($model,'password', array('class' => 'form-control')); ?>
		</div>
	</div>
	<div class="form-group rememberMe">
		<?php echo $form->label($model,'rememberMe', array('class' => 'col-sm-2 control-label')); ?>
		<?php echo $form->checkBox($model,'rememberMe'); ?>
	</div>
	<div class="form-group buttons">
		<div class="col-sm-offset-2 col-sm-4">
		<?php //echo CHtml::submitButton('Ingresar', array('class' =>'btn btn-default')); ?>
		<?php Yii::app()->user->ui->tbutton(CrugeTranslator::t('logon', "Login")); ?>
		</div>
	</div>
	<div class="form-group">
		<?php echo l('¿Olvidaste tu clave?', array('/usuario/recuperarclave')); ?>
		<?php if(Yii::app()->user->um->getDefaultSystem()->getn('registrationonlogin')===1)
			echo l('Regístrate', array('/usuario/registro'));
		?>
	</div>
<?php $this->endWidget(); ?>
<h1><?php echo CrugeTranslator::t('logon',"Login"); ?></h1>
<?php if(Yii::app()->user->hasFlash('loginflash')): ?>
<div class="flash-error">
	<?php echo Yii::app()->user->getFlash('loginflash'); ?>
</div>
<?php else: ?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'logon-form',
	'enableClientValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array(
		'role' => 'form', 
		'class' => 'form-horizontal', 
	),
)); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'username', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-4">
		<?php echo $form->textField($model,'username', array('class' => 'form-control')); ?>
		</div>
		<?php echo $form->error($model,'username', array('class' => 'flash-notice')); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'password', array('class' => 'col-sm-2 control-label')); ?>
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

	<?php
		//	si el componente CrugeConnector existe lo usa:
		//
		if(Yii::app()->getComponent('crugeconnector') != null){
		if(Yii::app()->crugeconnector->hasEnabledClients){ 
	?>
	<div class='crugeconnector'>
		<span><?php echo CrugeTranslator::t('logon', 'You also can login with');?>:</span>
		<ul>
		<?php 
			$cc = Yii::app()->crugeconnector;
			foreach($cc->enabledClients as $key=>$config){
				$image = CHtml::image($cc->getClientDefaultImage($key));
				echo "<li>".CHtml::link($image,
					$cc->getClientLoginUrl($key))."</li>";
			}
		?>
		</ul>
	</div>
	<?php }} ?>
	

<?php $this->endWidget(); ?>
</div>
<?php endif; ?>

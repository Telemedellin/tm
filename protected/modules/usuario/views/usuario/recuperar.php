<?php
$bc = array();
$bc['Usuario'] = bu('usuario');
$bc[] = 'Recuperar clave';
$this->breadcrumbs = $bc;
if($fondo_pagina == NULL)
	cs()->registerCss('background', 'body{background-image: none}');
else{
	$bg = bu('/images/' . $fondo_pagina);
	cs()->registerCss('background', 'body{background-image: url("' . $bg . '");}');
}
$this->pageTitle= 'Recuperar clave - ' . Yii::app()->name;
?>
<div id="micrositio" class="especiales">
	<div class="contenidoScroll">
		<h1>Recuperar clave</h1>
		<?php if(Yii::app()->user->hasFlash('pwdrecflash')): ?>
		<div class="flash-success">
			<?php echo Yii::app()->user->getFlash('pwdrecflash'); ?>
		</div>
		<?php else: ?>
		<?php 
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'recuperar-form',
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
			'htmlOptions' => array(
				'role' => 'form', 
				'class' => 'form-horizontal', 
			)
		)); 
		?>
		<div class="form-group">
			<?php echo $form->label($model,'username', array('class' => 'col-sm-2 control-label')); ?>
			<div class="col-sm-4">
			<?php echo $form->emailField($model,'username', array('class' => 'form-control')); ?>
			</div>
		</div>

		<?php if(CCaptcha::checkRequirements()): ?>
		<div class="row">
			<?php echo $form->labelEx($model,'verifyCode'); ?>
			<div>
			<?php $this->widget('CCaptcha'); ?>
			<?php echo $form->textField($model,'verifyCode'); ?>
			</div>
			<div class="hint"><?php echo CrugeTranslator::t("por favor ingrese los caracteres o digitos que vea en la imagen");?></div>
			<?php echo $form->error($model,'verifyCode'); ?>
		</div>
		<?php endif; ?>

		<div class="form-group buttons">
			<?php echo CHtml::submitButton('Recuperar', array('class' =>'btn btn-default')); ?>
		</div>

		<?php $this->endWidget(); ?>
		<?php endif; ?>
		<div class="hidden">
			<img src="<?php echo $bg ?>" width="1500" />
		</div>
	</div>
</div><!-- form -->
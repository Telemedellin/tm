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
			<div class="control-group">
				<?php echo $form->label($model, 'username', array('class' => 'control-label')); ?>
				<div class="controls">
				<?php echo $form->emailField($model, 'username'); ?>
				</div>
			</div>
			<?php if(CCaptcha::checkRequirements()): ?>
			<div class="row">
				<?php echo $form->labelEx($model, 'verifyCode', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php $this->widget('CCaptcha'); ?>
					<p><?php echo $form->textField($model, 'verifyCode'); ?></p>
					<div class="hint">
						<?php echo CrugeTranslator::t("Por favor ingrese los caracteres que vea en la imagen");?>
					</div>
				</div>
				<?php echo $form->error($model, 'verifyCode'); ?>
			</div>
			<?php endif; ?>
			<div class="control-group buttons">
				<div class="controls">
				<?php echo CHtml::submitButton('Recuperar', array('class' =>'btn btn-default')); ?>
				</div>
			</div>
			<?php $this->endWidget(); ?>
		<?php endif; ?>
		<div class="hidden">
			<img src="<?php echo $bg ?>" width="1500" />
		</div>
	</div>
</div><!-- form -->
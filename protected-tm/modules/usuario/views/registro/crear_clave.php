<?php
$bc = array();
$bc['Usuario'] = bu('usuario');
$bc['Registro'] = bu('usuario/registro');
$bc[] = 'Crear clave';
$this->breadcrumbs = $bc;
if($fondo_pagina == NULL)
	cs()->registerCss('background', 'body{background-image: none}');
else{
	$bg = bu('/images/' . $fondo_pagina);
	cs()->registerCss('background', 'body{background-image: url("' . $bg . '");}');
}
$this->pageTitle = 'Crear clave';
$this->pageDesc = 'Canal público cultural de la ciudad de Medellín. Programación, noticias, horarios.';
?>
<div id="micrositio" class="especiales">
	<div class="contenidoScroll">
		<h2>¡Crea tu contraseña… ya casi finalizamos!</h2>
		<?php foreach(Yii::app()->user->getFlashes() as $key => $message): ?>
			<div class="alert alert-block alert-<?php echo $key ?>"><?php echo $message ?></div>
		<?php endforeach ?>
		<?php
		$form = $this->beginWidget('CActiveForm', array(
		    'id'=>'crear-clave',
		    //'enableAjaxValidation'=>true,
		    'enableClientValidation'=>true,
		    'errorMessageCssClass' => 'alert alert-error', 
		    'htmlOptions' => array(
		    	'class' => 'form-horizontal',
		    ),
		)); ?>
		<p>Tu inicio de sesión se hará con el siguiente correo.</p>
		<div class="control-group">
			<?php echo $form->labelEx( $model, 'correo', array('class' => 'control-label') ); ?>
			<div class="controls">
				<?php echo $form->emailField($model, 'correo', array('readonly' => 'readonly')); ?>
				<?php echo $form->error($model, 'correo'); ?>
			</div>
		</div>
		<p>Debes crear una contraseña para poder iniciar sesión.</p>
		<div class="control-group">
			<?php echo $form->labelEx( $model, 'contrasena', array('class' => 'control-label') ); ?>
			<div class="controls">
				<?php echo $form->passwordField($model, 'contrasena'); ?>
				<?php echo $form->error($model, 'contrasena'); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx( $model, 'repetir_contrasena', array('class' => 'control-label') ); ?>
			<div class="controls">
				<?php echo $form->passwordField($model, 'repetir_contrasena'); ?>
				<?php echo $form->error($model, 'repetir_contrasena'); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->checkBox($model, 'terminos'); ?> 
			<?php echo l('Reconozco que he leído y acepto los términos y condiciones', bu('telemedellin/utilidades/politicas-de-tratamiento-de-datos-personales'), array('target' => '_blank')); ?>
		</div>
		<div class="row buttons">
			<?php echo CHtml::submitButton("Registrarse"); ?>
		</div>
		<?php $this->endWidget(); ?>
		<div class="hidden">
			<img src="<?php echo $bg ?>" width="1500" />
		</div>
    </div>
</div>
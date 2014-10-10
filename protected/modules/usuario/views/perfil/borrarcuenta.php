<?php
$bc = array();
$bc['Usuario'] = bu('usuario');
$bc['Perfil'] = bu('usuario/perfil');
$bc[] = 'Borrar cuenta';
$this->breadcrumbs = $bc;
if($fondo_pagina == NULL)
	cs()->registerCss('background', 'body{background-image: none}');
else{
	$bg = bu('/images/' . $fondo_pagina);
	cs()->registerCss('background', 'body{background-image: url("' . $bg . '");}');
}
$this->pageTitle = 'Borrar cuenta';
$this->pageDesc = 'Canal público cultural de la ciudad de Medellín. Programación, noticias, horarios.';
?>
<div id="micrositio" class="especiales">
	<div class="contenidoScroll">
	<h2>Borrar cuenta de Telemedellín</h2>
	<p>Al borrar tu cuenta dejarás de recibir beneficios e invitaciones exclusivas de Telemedellín, además perderás los puntos que tengas acumulados hasta el momento y no podrás recuperarlos.</p>
	<p>Para confirmar el borrado de tu cuenta, ingresa tu contraseña en el siguiente campo</p>
	<?php foreach(Yii::app()->user->getFlashes() as $key => $message): ?>
		<div class="alert alert-block alert-<?php echo $key ?>"><?php echo $message ?></div>
	<?php endforeach ?>
	<?php
	$form = $this->beginWidget('CActiveForm', array(
	    'id'=>'borrar-cuenta',
	    'errorMessageCssClass' => 'alert alert-error', 
	    'htmlOptions' => array(
	    	'class' => 'form-horizontal',
	    ),
	)); ?>
	<div class="control-group">
		<?php echo CHtml::label( 'Contraseña', 'contrasena', array('class' => 'control-label') ); ?>
		<div class="controls">
			<?php echo CHtml::passwordField('contrasena'); ?>
		</div>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton("Borrar cuenta"); ?>
	</div>
	<?php $this->endWidget(); ?>
	<div class="hidden">
		<img src="<?php echo $bg ?>" width="1500" />
	</div>
	</div>
</div>
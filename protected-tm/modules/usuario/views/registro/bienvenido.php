<?php
$bc = array();
$bc['Usuario'] = bu('usuario');
$bc['Registro'] = bu('usuario/registro');
$bc[] = 'Bienvenido';
$this->breadcrumbs = $bc;
if($fondo_pagina == NULL)
	cs()->registerCss('background', 'body{background-image: none}');
else{
	$bg = bu('/images/' . $fondo_pagina);
	cs()->registerCss('background', 'body{background-image: url("' . $bg . '");}');
}
$this->pageTitle = 'Verificación';
$this->pageDesc = 'Canal público cultural de la ciudad de Medellín. Programación, noticias, horarios.';
?>
<div id="micrositio" class="especiales">
	<div class="contenidoScroll">
		<?php if($mensaje == 'correo'): ?>
			<h2>¡Eso es todo, bienvenido!</h2>
		<?php endif ?>
		<?php if($mensaje == 'red_social'): ?>
			<h2>¡Bienvenido, "<?php echo $nombre ?>"!</h2>
			<p>Ya haces parte de Telemedellín ¡Aquí te ves!</p>
			<p>Tu nos has visto muchas veces y nos conoces, pero nosotros aún no tenemos el privilegio de conocerte. Por eso te invitamos a que nos regales 2 minutos para llenar una información básica sobre ti.</p>
			<p>Si deseas puedes hacerlo en otro momento,</p>
			<p><a href="<?php echo bu('usuario/perfil')?>">Quiero hacerlo ya</a></p>
			<p><a href="<?php echo bu()?>">Si deseas puedes hacerlo en otro momento.</a></p>
		<?php endif ?>
		<?php if($mensaje == 'correo' || $mensaje == 'login'): ?>
		<p>Ya eres parte de Telemedellín ¡Aquí te ves! Inicia sesión y comienza a disfrutar de todas las sorpresas e información que tenemos para ti. </p>
		<?php endif ?>
		<?php if( Yii::app()->user->isGuest ): ?>
		<?php $this->renderPartial('../usuario/_login_form', array('model' => $model)) ?>
		<?php endif ?>
	<div class="hidden">
		<img src="<?php echo $bg ?>" width="1500" />
	</div>
	</div>
</div>
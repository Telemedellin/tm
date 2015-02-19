<?php
$bc = array();
$bc['Usuario'] = bu('usuario');
$bc['Registro'] = bu('usuario/registro#correo');
$bc[] = 'Verificación';
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
	<h2>¡Ya casi terminamos!</h2>
	<p>Para verificar la propiedad de tu correo, te enviamos un e-mail a la dirección electrónica que escribiste en el formulario. Te llegará un enlace al que debes dar clic y ¡Listo! Estarás registrado para que estemos más cerca, conectados e informados.</p>
	
	<div class="hidden">
		<img src="<?php echo $bg ?>" width="1500" />
	</div>
	</div>
</div>
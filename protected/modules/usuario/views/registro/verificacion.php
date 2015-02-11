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
	<p>Para verificar la propiedad de tu correo, te hemos enviado un e-mail al correo que escribiste en el formulario. Te llegará un enlace en el que debes hacer clic y listo, estarás registrado para comenzar a disfrutar de los beneficios de Telemedellín.</p>
	
	<div class="hidden">
		<img src="<?php echo $bg ?>" width="1500" />
	</div>
	</div>
</div>
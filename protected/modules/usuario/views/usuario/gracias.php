<?php
$bc = array();
$bc['Usuario'] = bu('usuario');
$bc[] = 'Gracias';
$this->breadcrumbs = $bc;
if($fondo_pagina == NULL)
	cs()->registerCss('background', 'body{background-image: none}');
else{
	$bg = bu('/images/' . $fondo_pagina);
	cs()->registerCss('background', 'body{background-image: url("' . $bg . '");}');
}
$this->pageTitle = 'Gracias';
$this->pageDesc = 'Canal público cultural de la ciudad de Medellín. Programación, noticias, horarios.';
?>
<div id="micrositio" class="especiales">
	<div class="contenidoScroll">
	<h2>¡Hemos recibido tu información!</h2>
	<p>Muchas gracias por compartir tu opinión con nosotros.</p>
	<div class="hidden">
		<img src="<?php echo $bg ?>" width="1500" />
	</div>
	</div>
</div>
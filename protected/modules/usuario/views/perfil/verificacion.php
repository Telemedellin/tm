<?php
$bc = array();
$bc['Usuario'] = bu('usuario');
$bc['Registro'] = bu('usuario/perfil');
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
	<?php if( Yii::app()->user->getFlash('verificacion')): ?>
		<h2>¡Listo!</h2>
	<?php endif; ?>
	<div class="hidden">
		<img src="<?php echo $bg ?>" width="1500" />
	</div>
	</div>
</div>
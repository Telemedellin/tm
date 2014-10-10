<?php
$bc = array();
$bc['Usuario'] = bu('usuario');
$bc[] = 'Perfil';
$this->breadcrumbs = $bc;
if($fondo_pagina == NULL)
	cs()->registerCss('background', 'body{background-image: none}');
else{
	$bg = bu('/images/' . $fondo_pagina);
	cs()->registerCss('background', 'body{background-image: url("' . $bg . '");}');
}
$this->pageTitle = 'Perfil';
$this->pageDesc = 'Canal público cultural de la ciudad de Medellín. Programación, noticias, horarios.';
?>
<div id="menu_micrositio" class="usuario perfil especiales">
	<ul>
		<li><?php echo l( 'Información personal', array('/usuario/perfil') ) ?></li>
		<li><?php echo l( 'Trivia semanal', array('/trivia') ) ?></li>
		<li><?php echo l( 'Salir', array('/usuario/salir') ) ?></li>
	</ul>
</div>
<div id="micrositio" class="especiales">
	<div class="contenidoScroll">
		<?php $this->renderPartial('_perfil_form', array('model' => $model)); ?>
		<div class="hidden">
			<img src="<?php echo $bg ?>" width="1500" />
		</div>
    </div>
</div>
<?php
$bc = array();
$bc['Usuario'] = bu('usuario');
$bc[] = 'Registro';
$this->breadcrumbs = $bc;
if($fondo_pagina == NULL)
	cs()->registerCss('background', 'body{background-image: none}');
else{
	$bg = bu('/images/' . $fondo_pagina);
	cs()->registerCss('background', 'body{background-image: url("' . $bg . '");}');
}
$this->pageTitle = 'Registro';
$this->pageDesc = 'Canal público cultural de la ciudad de Medellín. Programación, noticias, horarios.';
cs()->registerScript( 
	'registro', 
	'
	$(".registro-correo").on("click", abrir_registro);
	function abrir_registro(e)
	{
		$( "form[id ^= correo]" ).hide();
		$( $(this).attr("href") ).show();
		$("#micrositio").mCustomScrollbar("update");
	}
	');
?>
<div id="micrositio" class="especiales">
	<div class="contenidoScroll">
		<h2>¡Regístrate y disfruta de nuestros beneficios!</h2>
		<p>En este contenido se debe dar los argumentos al usuario sobre los beneficios...</p>
		<ul>
			<li>Beneficio</li>
			<li>Beneficio 2</li>
			<li>Beneficio 3</li>
			<li>Beneficio 4</li>
		</ul>
		<p>Ingresar a Telemedellín es muy fácil, sólo debes seleccionar si quieres acceder con tu correo electrónico o con una red social:</p>
		<div id="status"></div>
		<ul>
			<li><a href="#correo" class="btn-registro registro-correo">Correo</a></li>
			<li><a href="<?php echo bu('usuario/registro/facebook') ?>" class="btn-registro registro-facebook">Facebook</a></li>
			<li><a href="<?php echo bu('usuario/registro/google') ?>" class="btn-registro registro-google">Google</a></li>
		</ul>
	<?php $this->renderPartial('_registro_form', array('model' => $model)); ?>
	<div class="hidden">
		<img src="<?php echo $bg ?>" width="1500" />
	</div>
    </div>
</div>
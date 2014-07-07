<?php
$bc = array();
$bc[] = 'Registro';
$this->breadcrumbs = $bc;
$this->pageTitle = 'Registro';
if($fondo_pagina == NULL)
	cs()->registerCss('background', 'body{background-image: none}');
else{
	$bg = bu('/images/' . $fondo_pagina);
	cs()->registerCss('background', 'body{background-image: url("' . $bg . '");}');
}
?>

<?php
$this->pageTitle = 'Registro';
$this->pageDesc = 'Canal público cultural de la ciudad de Medellín. Programación, noticias, horarios.';
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
		<ul>
			<li>Correo</li>
			<li>Facebook</li>
			<li>Twitter</li>
		</ul>
	<?php $this->renderPartial('_registro_form', array('model' => $model)); ?>
	<div class="hidden">
		<img src="<?php echo $bg ?>" width="1500" />
	</div>
    </div>
</div>
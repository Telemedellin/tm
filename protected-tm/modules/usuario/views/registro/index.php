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
		$(".btn-registro").addClass("disabled");
		$(this).removeClass("disabled");
	}
	');
?>
<div id="micrositio" class="especiales">
	<div class="contenidoScroll">
		<p>Porque somos el canal público de la cuidad; la ventana de Medellín al mundo y el canal del ¡Aquí te ves!</p>
		<p>¡Regístrate para que estemos más cerca, conectados e informados!</p>
		<ul>
			<li>Nos sintonizas y ganas con nuestro programa Puntos ™. </li>
			<li>Te mantienes informado de nuestra programación, novedades y eventos de ciudad.</li>
			<li>Participas con un sólo click en nuestros concursos.</li>
			<li>Asistes a la grabación de nuestros programas.</li>
			<li>Recibes invitaciones exclusivas a los eventos realizados por Telemedellín y nuestros aliados.</li>
			<li>Tienes un contacto directo con nosotros para resolver tus inquietudes y atender tus reclamos o </li>solicitudes. 
		</ul>
		<p>Ingresar a Telemedellín es muy fácil, sólo debes seleccionar si quieres acceder con tu correo electrónico o con una red social:</p>
		<div id="status"></div>
		<ul class="btns-registro">
			<li><a href="#correo" class="btn-registro registro-correo">Tu correo electrónico</a></li>
			<li><a href="<?php echo bu('usuario/registro/facebook') ?>" class="btn-registro registro-facebook">Tu cuenta de Facebook</a></li>
			<li><a href="<?php echo bu('usuario/registro/google') ?>" class="btn-registro registro-google">Tu correo de Google</a></li>
		</ul>
	<?php $this->renderPartial('_registro_form', array('model' => $model)); ?>
	<div class="hidden">
		<img src="<?php echo $bg ?>" width="1500" />
	</div>
    </div>
</div>
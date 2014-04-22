<?php
$bc = array();
if($seccion->url->slug != 'sin-seccion')
{
	$bc[ucfirst($seccion->nombre)] =  bu( $seccion->url->slug ) ;
}
($pagina->id != $micrositio->pagina_id) ? $bc[ucfirst($micrositio->nombre)] = bu( $micrositio->url->slug ) : $bc[] = ucfirst($micrositio->nombre);
($pagina->id != $micrositio->pagina_id) ? $bc[] = ucfirst($pagina->nombre) : false;
$this->breadcrumbs = $bc;
$pt = ($pagina->id != $micrositio->pagina_id) ? ucfirst($pagina->nombre) . ' - ': '';
$this->pageTitle = $pt . $micrositio->nombre;

if($fondo_pagina == NULL)
	cs()->registerCss('background', 'body{background-image: none}');
else{
	$bg = bu('/images/' . $fondo_pagina);
	cs()->registerCss('background', 'body{background-image: url("' . $bg . '");}');
}
?>
<div id="content">
	<?php if(isset($menu) && $menu): ?>
	<div id="menu_micrositio">
		<?php $this->widget( 'MenuW', array( 'id' => $menu ) ); ?>
	</div>
	<?php endif;?>
	<div id="micrositio" class="<?php echo $pagina->tipoPagina->tabla ?> <?php echo (!is_null($pagina->clase)) ? $pagina->clase : '' ?>" data-micrositio-id="<?php echo $micrositio->id; ?>" data-pagina-id="<?php echo $pagina->id; ?>">
		<h1><?php echo $micrositio->nombre?><?php echo ($pagina->id != $micrositio->pagina_id)?', ' . lcfirst($pagina->nombre):''?></h1>
		<?php echo $contenido; ?>
	</div>
	<?php if($formulario || $galeria || $video):?>
	<div style="clear:both;"></div>
	<div id="menu_inferior">
		<?php if($formulario): ?>
			<a href="<?php echo bu($micrositio->url->slug) ?>/escribenos" class="formulario" title="Ir al formulario de <?php echo $micrositio->nombre ?>"><span class="iconoForm"></span>
				<span><?php echo ($seccion->nombre == 'Concursos')? 'Formulario' : 'Escríbenos'; ?></span>
			</a>
		<?php endif;?>
		<?php if($galeria): ?>
			<a href="<?php echo bu($micrositio->url->slug) ?>#imagenes" class="fancybox fancybox.ajax imagenes" title="Ver las imágenes de <?php echo $micrositio->nombre ?>">
				<span class="iconoImagen"></span><span>Imágenes</span>
			</a>
		<?php endif;?>
		<?php if($video): ?>
			<a href="<?php echo bu($micrositio->url->slug) ?>#videos" class="fancybox fancybox.ajax videos" title="Ver los videos de <?php echo $micrositio->nombre ?>"><span class="iconoVideo"></span><span>Videos</span></a>
		<?php endif;?>
	</div>
	<?php endif; ?>
	<?php if( isset( $micrositio->redSocials ) && count($micrositio->redSocials) ):  ?>
	<div id="redes_micrositio" class="redes">
		<p>Visitá este programa en:</p>
		<ul>
		<?php foreach( $micrositio->redSocials as $red ): ?>
			<li class="<?php echo strtolower($red->tipoRedSocial->nombre) ?>">
				<a href="<?php echo $red->tipoRedSocial->url_base . $red->usuario ?>" target="_blank" title="<?php echo $red->tipoRedSocial->nombre ?> de <?php echo $micrositio->nombre ?>" rel="nofollow">
					<?php echo $red->tipoRedSocial->nombre ?>
				</a>
			</li>
		<?php endforeach;?>
		</ul>
	</div>
	<?php endif; ?>
</div>
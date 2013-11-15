<?php
$bc = array();
if($seccion->url->slug != 'sin-seccion')
{
	$bc[ucfirst($seccion->nombre)] =  bu( $seccion->url->slug ) ;
}

($pagina->id != $micrositio->pagina_id) ? $bc[ucfirst($micrositio->nombre)] = bu( $micrositio->url->slug ) : $bc[] = ucfirst($micrositio->nombre);
($pagina->id != $micrositio->pagina_id) ? $bc[] = ucfirst($pagina->nombre) : false;
$this->breadcrumbs = $bc;
$this->pageTitle = $micrositio->nombre;

if( !empty($fondo_pagina) )
{
	$bg = bu('/images/' . $fondo_pagina);
}elseif( !empty($micrositio->background) )
{
	$bg = bu('/images/'.$micrositio->background);
}else
{
	$bg = bu('/images/backgrounds/generica-interna-1.jpg');
}
cs()->registerCss('background', 'body{background-image: url("' . $bg . '");}');
cs()->registerScript( 'scroll', 
	'$("#micrositio").mCustomScrollbar({
		scrollType: "pixels",
		updateOnContentResize: true, 
		scrollButtons: {
			enable: true
		}
	});
	window.updateScrollbar = function() {
		/*$("#micrositio").mCustomScrollbar("destroy");
		$("#micrositio").mCustomScrollbar({
			scrollType: "pixels",
			updateOnContentResize: true, 
			scrollButtons: {
				enable: true
			}
		});*/
		$("#micrositio").mCustomScrollbar("update");
	}
	',
	CClientScript::POS_READY
);
?>
<?php if( isset( $micrositio->redSocials ) && count($micrositio->redSocials) ):  ?>
<div id="redes_micrositio" class="redes">
	<p>Visitanos en</p>
	<ul>
	<?php foreach( $micrositio->redSocials as $red ): ?>
		<li class="<?php echo strtolower($red->tipoRedSocial->nombre) ?>">
			<a href="<?php echo $red->tipoRedSocial->url_base . $red->usuario ?>" target="_blank" rel="nofollow">
				<?php echo $red->tipoRedSocial->nombre ?>
			</a>
		</li>
	<?php endforeach;?>
	</ul>
</div>
<?php endif; ?>
<?php if(isset($menu) && $menu): ?>
<div id="menu_micrositio">
	<?php $this->widget( 'MenuW', array( 'id' => $menu ) ); ?>
</div>
<?php endif;?>

<div id="micrositio" class="<?php echo $pagina->tipoPagina->tabla ?> <?php echo (!is_null($pagina->clase)) ? $pagina->clase : '' ?>" data-micrositio-id="<?php echo $micrositio->id; ?>" data-pagina-id="<?php echo $pagina->id; ?>">
	<div class="contenidoScroll">
	<?php echo $contenido; ?>
	<div class="hidden">
		<img src="<?php echo $bg ?>" width="1500" />
	</div>
    </div>
</div>

<?php if($formulario || $galeria || $video):?>
<div style="clear:both;"></div>
<div id="menu_inferior">
	<?php if($formulario): ?>
		<a href="<?php echo bu($micrositio->url->slug) ?>/escribenos" class="formulario"><span class="iconoForm"></span>
			<span>
				<?php if($seccion->nombre == 'Concursos'):?>
					Formulario
				<?php else:?>
					Escribinos
				<?php endif?>
			</span>
		</a>
	<?php endif;?>
	<?php if($galeria): ?>
		<a href="<?php echo bu($micrositio->url->slug) ?>#imagenes" class="fancybox fancybox.ajax imagenes">
			<span class="iconoImagen"></span><span>Imágenes</span>
		</a>
	<?php endif;?>
	<?php if($video): ?>
		<a href="<?php echo bu($micrositio->url->slug) ?>#videos" class="fancybox fancybox.ajax videos"><span class="iconoVideo"></span><span>Videos</span></a>
	<?php endif;?>
</div>
<?php endif; ?>
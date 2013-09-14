<?php
$bc = array();
if($seccion->url->slug != 'sin-seccion')
{
	$bc[ucfirst($seccion->nombre)] =  bu( $seccion->url->slug ) ;
}

($pagina->id != $micrositio->pagina_id) ? $bc[ucfirst($micrositio->nombre)] = bu( $micrositio->url->slug ) : $bc[] = ucfirst($micrositio->nombre);
($pagina->id != $micrositio->pagina_id) ? $bc[] = ucfirst($pagina->nombre) : false;
$this->breadcrumbs = $bc;

if( !is_null($micrositio->background) )
	cs()->registerCss('background', 'body{background-image: url("' . bu() . $micrositio->background . '");}');

cs()->registerScript( 'scroll', 
	'$("#micrositio").mCustomScrollbar({
		scrollType: "pixels",
		scrollButtons: {
			enable: true
		}
	});
	',
	CClientScript::POS_READY
);
?>
<?php if( isset( $micrositio->red_social ) && count($micrositio->red_social) ):  ?>
<div id="redes_micrositio" class="redes">
	<p>Visítanos en</p>
	<ul>
	<?php foreach( $micrositio->red_social as $red ): ?>
		<li class="<?php echo strtolower($red->tipoRedSocial->nombre) ?>">
			<a href="<?php echo $red->tipoRedSocial->url_base . $red->usuario ?>">
				<?php echo $red->tipoRedSocial->nombre ?>
			</a>
		<?php $red->nombre . ' ' . $red->usuario; ?>
		<?php $red->tipoRedSocial->nombre . ' ' . $red->tipoRedSocial->icono . ' ' . $red->tipoRedSocial->url_base ?>
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
<div id="micrositio" class="<?php echo $pagina->tipoPagina->tabla ?> <?php echo (!is_null($pagina->clase)) ? $pagina->clase : '' ?>">
	<?php echo $contenido; ?>
</div>
<div id="menu_inferior">
<?php if(isset($formulario) && $formulario): ?>
	<?php echo $formulario ?>
	<p>Formulario</p>
<?php endif;?>
<?php if(isset($galeria) && $galeria): ?>
	<a href="<?php echo bu($micrositio->url->slug) ?>#imagenes" class="fancybox fancybox.ajax imagenes">Imágenes</a>
<?php endif;?>
<?php if(isset($videos) && $videos): ?>
	<?php echo $videos ?>
	<a href="#">Videos</a>
<?php endif;?>
</div>

<?php /*?m=<?php echo $micrositio->id*/ ?>
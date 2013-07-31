<?php
$bc = array();
if($seccion->url->slug != 'telemedellin')
{
	$bc[ucfirst($seccion->nombre)] =  bu( $seccion->url->slug ) ;
}

($pagina->id != $micrositio->pagina_id) ? $bc[ucfirst($micrositio->nombre)] = bu( $micrositio->url->slug ) : $bc[] = ucfirst($micrositio->nombre);
($pagina->id != $micrositio->pagina_id) ? $bc[] = ucfirst($pagina->nombre) : false;
$this->breadcrumbs = $bc;

cs()->registerCss('background', 'body{background-image: url("' . bu() . $micrositio->background . '");}');

cs()->registerScriptFile( bu('js/jquery.mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js'), CClientScript::POS_END );
cs()->registerScript( 'scroll', 
	'$("#micrositio").mCustomScrollbar({
		scrollButtons:{
			enable:true
		}
	});',
	CClientScript::POS_READY
);

if( $pagina->tipoPagina->tabla == 'novedades' )
{
	cs()->registerScriptFile( bu('js/jquery.isotope/jquery.isotope.min.js'), CClientScript::POS_END );
	cs()->registerScript( 'isotope', 
		'$(".mCSB_container").isotope({
		  itemSelector : "div",
		  //layoutMode : "fitRows"
		});',
		CClientScript::POS_READY
	);
}


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
<div id="micrositio" class="<?php echo $pagina->tipoPagina->tabla ?>">
	<?php echo $contenido; ?>
</div>
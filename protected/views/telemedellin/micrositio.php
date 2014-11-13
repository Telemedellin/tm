<?php
$bc = array();
if($seccion->id != 9)
{
	$bc[ucfirst($seccion->nombre)] =  bu( $seccion->url->slug );
}
($pagina->id != $micrositio->pagina_id) ? $bc[ucfirst($micrositio->nombre)] = bu( $micrositio->url->slug ) : $bc[] = ucfirst($micrositio->nombre);
($pagina->id != $micrositio->pagina_id) ? $bc[] = ucfirst($pagina->nombre) : false;
$this->breadcrumbs = $bc;
$pt = ($pagina->id != $micrositio->pagina_id) ? ucfirst($pagina->nombre) . ' - ': '';
$this->pageTitle = $pt . str_replace('"', "'", $micrositio->nombre);

if($fondo_pagina == NULL)
	cs()->registerCss('background', 'body{background-image: none}');
else{
	$bg = bu('/images/' . $fondo_pagina);
	cs()->registerCss('background', 'body{background-image: url("' . $bg . '");}');
	$this->pageImg = $bg;
}
?>
<?php if( isset( $micrositio->redSocials ) && count($micrositio->redSocials) ):  ?>
<div id="redes_micrositio" class="redes">
	<p>Visitá este programa en:</p>
	<ul>
	<?php foreach( $micrositio->redSocials as $red ): ?>
		<li class="<?php echo strtolower($red->tipoRedSocial->nombre) ?>">
			<a href="<?php echo $red->tipoRedSocial->url_base . $red->usuario ?>" target="_blank" title="<?php echo $red->tipoRedSocial->nombre ?> de <?php echo str_replace('"', "'", $micrositio->nombre) ?>" rel="nofollow">
				<?php echo $red->tipoRedSocial->nombre ?>
			</a>
		</li>
	<?php endforeach;?>
	</ul>
</div>
<?php endif; ?>
<?php if(isset($menu) && $menu): ?>
<div id="menu_micrositio" class="<?php echo $pagina->tipoPagina->tabla ?> <?php echo strtolower($seccion->nombre) ?>">
	<?php $this->widget( 'MenuW', array( 'id' => $menu ) ); ?>
</div>
<?php endif;?>
<div id="micrositio" class="<?php echo $pagina->tipoPagina->tabla ?> <?php echo (!is_null($pagina->clase)) ? $pagina->clase : '' ?> <?php echo strtolower($seccion->nombre) ?>" data-micrositio-id="<?php echo $micrositio->id; ?>" data-pagina-id="<?php echo $pagina->id; ?>">
	<div class="contenidoScroll">
	<?php echo $contenido; ?>
	<div class="hidden">
		<img src="<?php echo $bg ?>" width="1500" />
	</div>
    </div>
</div>
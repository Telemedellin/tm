<?php
$bc = array();
if($seccion->url->slug != 'telemedellin')
{
	$bc[ucfirst($seccion->nombre)] = bu( $seccion->url->slug );
}

($pagina->id != $micrositio->pagina_id) ? $bc[ucfirst($micrositio->nombre)] = bu( $micrositio->url->slug ) : $bc[] = ucfirst($micrositio->nombre);
($pagina->id != $micrositio->pagina_id) ? $bc[] = ucfirst($pagina->nombre) : false;
$this->breadcrumbs = $bc;

cs()->registerCss('background', 'body{background-image: url("' . bu() . $micrositio->background . '");}');
?>
<div>
	<?php if(isset($menu) && $menu): ?>
	<div class="menu_micrositio">
		<?php $this->widget( 'MenuW', array( 'id' => $menu ) ); ?>
	</div>
	<?php endif;?>
	<?php echo $contenido; ?>
	<?php echo $this->renderPartial('_redes'); ?>
</div>
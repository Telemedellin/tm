<?php 
$bc = array();
$bc[] = ucfirst($seccion->nombre);
$this->breadcrumbs = $bc;
$this->pageTitle = $seccion->nombre;
if($seccion->meta_descripcion != '') $this->pageDesc = $seccion->meta_descripcion;
$destacados = '';
if($seccion->url->slug == 'concursos')
{
	$bg = bu('/images/backgrounds/concursos/general-de-concurso.jpg');
	cs()->registerCss('background', 'body{background-image: url("' . $bg . '");}');
	$this->pageImg = $bg;
}
	
cs()->registerScript( 'scroll', 
	'$(".listado").mCustomScrollbar({
		scrollType: "pixels",
		scrollButtons:{
			mouseWheel:false,
			enable: true,
			horizontalScroll:true
		}
	});',
	CClientScript::POS_READY
);
?>
<div id="seccion" class="<?php echo $seccion->url->slug; ?>">
	<div class="listado">
	<?php foreach($micrositios as $micrositio):?>
		<h2>
			<a href="<?php echo bu($micrositio->url->slug); ?>" title="Ir al micrositio <?php echo str_replace('"', "'", $micrositio->nombre); ?>"><?php echo $micrositio->nombre; ?></a>
		</h2>
	<?php endforeach; ?>
	</div>
</div>
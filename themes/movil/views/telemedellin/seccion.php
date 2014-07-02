<?php 
$bc = array();
$bc[] = ucfirst($seccion->nombre);
$this->breadcrumbs = $bc;
$this->pageTitle = $seccion->nombre;
if($seccion->meta_descripcion != '') $this->pageDesc = $seccion->meta_descripcion;
$destacados = '';
if($seccion->url->slug == 'concursos')
	cs()->registerCss('background', 'body{background-image: url("' . bu('/images/backgrounds/concursos/general-de-concurso.jpg') . '");}');
?>
<div id="seccion" class="<?php echo $seccion->url->slug; ?>">
	<div class="listado">
	<?php foreach($micrositios as $micrositio):?>
		<h2>
			<a href="<?php echo bu($micrositio->url->slug); ?>" title="Ir al micrositio <?php echo $micrositio->nombre; ?>"><?php echo $micrositio->nombre; ?></a>
		</h2>
	<?php endforeach; ?>
	</div>
</div>
<?php 
$bc = array();
$bc[] = ucfirst($seccion->nombre);
$this->breadcrumbs = $bc;
$this->pageTitle = $seccion->nombre;
$destacados = '';
if($seccion->url->slug == 'concursos')
	cs()->registerCss('background', 'body{background-image: url("' . bu('/images/backgrounds/concursos/general-de-concurso.jpg') . '");}');
?>
<div id="seccion" class="<?php echo $seccion->url->slug; ?>">
	<div class="listado">
	<?php foreach($micrositios as $micrositio):?>
		<p>
			<a href="<?php echo bu($micrositio->url->slug); ?>"><?php echo $micrositio->nombre; ?></a>
		</p>
	<?php endforeach; ?>
	</div>
</div>
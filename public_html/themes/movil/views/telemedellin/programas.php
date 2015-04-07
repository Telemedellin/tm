<?php 
$bc = array();
$bc[] = ucfirst($seccion->nombre);
$this->breadcrumbs = $bc;
$this->pageTitle = $seccion->nombre;
if($seccion->meta_descripcion != '') $this->pageDesc = $seccion->meta_descripcion;
$destacados = '';
?>
<div id="seccion" class="<?php echo $seccion->url->slug; ?>">
	<div class="listado">
		<div class="inner">
		<?php foreach($micrositios as $micrositio):?>
			<p>
				<a href="<?php echo bu($micrositio->url->slug); ?>"><?php echo $micrositio->nombre; ?></a>
			</p>
		<?php endforeach; ?>
		</div>
	</div>
</div>
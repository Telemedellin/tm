<?php 
$bc = array();
$bc[] = ucfirst($seccion->nombre);
$this->breadcrumbs = $bc;
$this->pageTitle = $seccion->nombre;
$destacados = '';
?>
<div id="seccion" class="<?php echo $seccion->url->slug; ?>">
	<div class="filtro">
	 	<form method="get"> 
	        <input type="text" id="s" name="q" value="Filtrar..." />
	    </form> 
	</div>
	<div class="listado">
	<?php foreach($micrositios as $micrositio):?>
		<?php if($micrositio->destacado): ?>
			<?php 
				$destacados .= '<p><a href="' . bu($micrositio->url->slug) . '">';
				$destacados .= '<img src="' . bu($micrositio->miniatura) . '" alt="' . $micrositio->nombre . '"/>';
				$destacados .= '</a></p>' . "\n\r";
			?>
		<?php else: ?>
		<p>
			<a href="<?php echo bu($micrositio->url->slug); ?>"><?php echo $micrositio->nombre; ?></a>
		</p>
		<?php endif; ?>
	<?php endforeach; ?>
	</div>
	<?php if($destacados != ''): ?>
	<div class="destacados">
		<?php echo $destacados ?>
	</div>
	<?php endif; ?>
</div>
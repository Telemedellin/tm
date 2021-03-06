<?php 
$bc = array();
$bc[] = ucfirst($seccion->nombre);
$this->breadcrumbs = $bc;
$this->pageTitle = $seccion->nombre;
if($seccion->meta_descripcion != '') $this->pageDesc = $seccion->meta_descripcion;
$destacados = '';
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
	<div class="filtro"> 
	    <input type="text" id="txtFiltro" name="txtFiltro" placeholder="Filtrar <?php echo $seccion->url->slug; ?>..." />
	</div>
	<div class="listado">
		<div class="inner">
		<?php foreach($micrositios as $micrositio):?>
			<?php if($micrositio->destacado): ?>
				<?php 
					$destacados .= '<p><a href="' . bu($micrositio->url->slug) . '">';
					$destacados .= '<img src="' . bu('images/'.$micrositio->miniatura) . '" alt="' . str_replace('"', "'", $micrositio->nombre) . '"/>';
					$destacados .= '</a></p>' . "\n\r";
				?>
			<?php else: ?>
			<p>
				<a href="<?php echo bu($micrositio->url->slug); ?>"><?php echo str_replace('"', "'", $micrositio->nombre); ?></a>
			</p>
			<?php endif; ?>
		<?php endforeach; ?>
		</div>
	</div>
	<?php if($destacados != ''): ?>
	<div class="destacados">
		<?php echo $destacados ?>
	</div>
	<?php endif; ?>
</div>
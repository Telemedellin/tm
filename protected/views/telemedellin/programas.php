<?php 
$bc = array();
$bc[] = ucfirst($seccion->nombre);
$this->breadcrumbs = $bc;
$this->pageTitle = $seccion->nombre;
$destacados = '';
cs()->registerScript( 'filtro', 
	'$("#txtFiltro").keyup(function(){
		var table = $(".listado");
		var value = this.value;
		table.find("p").each(function(index, row) {
			var allCells = $(row).find("a");
			if(allCells.length > 0) {
				var found = false;
				allCells.each(function(index, a) {
					var regExp = new RegExp(value, "i");
					if(regExp.test($(a).text())) {
						found = true;
						return false;
					}
				});
				if (found == true) $(row).show();
				else $(row).hide();
			}
		});			
	});',
	CClientScript::POS_READY
);

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
	 	<form method="get"> 
	        <input type="text" id="txtFiltro" name="txtFiltro" placeholder="Filtrar <?php echo $seccion->url->slug; ?>..." />
	    </form> 
	</div>
	<div class="listado">
		<div class="inner">
		<?php foreach($micrositios as $micrositio):?>
			<?php if($micrositio->destacado): ?>
				<?php 
					$destacados .= '<p><a href="' . bu($micrositio->url->slug) . '">';
					$destacados .= '<img src="' . bu('images/'.$micrositio->miniatura) . '" alt="' . $micrositio->nombre . '"/>';
					$destacados .= '</a></p>' . "\n\r";
				?>
			<?php else: ?>
			<p>
				<a href="<?php echo bu($micrositio->url->slug); ?>"><?php echo $micrositio->nombre; ?></a>
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
	sdfsdfsdfs
</div>
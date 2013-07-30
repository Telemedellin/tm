<?php 
$bc = array();
$bc[] = ucfirst($seccion->nombre);
$this->breadcrumbs = $bc;
$this->pageTitle = $seccion->nombre;

cs()->registerScriptFile( bu('js/jquery.mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js'), CClientScript::POS_END );
cs()->registerScript( 'scroll', 
	'$("#seccion").mCustomScrollbar({
		scrollButtons:{
			enable:true
		}
	});',
	CClientScript::POS_READY
);

cs()->registerScriptFile( bu('js/jquery.isotope/jquery.isotope.min.js'), CClientScript::POS_END );
	cs()->registerScript( 'isotope', 
		'$(".mCSB_container").isotope({
		  itemSelector : "div",
		  layoutMode : "fitRows"
		});',
		CClientScript::POS_READY
	);
?>
<div id="seccion" class="<?php echo $seccion->url->slug; ?>">
<?php foreach($micrositios as $micrositio):?>
	<div <?php if($micrositio->destacado) echo 'class="destacado"'?> style="background-image: url('<?php echo bu( $micrositio->miniatura );?>');">
		<a href="<?php echo bu($micrositio->url->slug); ?>"><h2><?php echo $micrositio->nombre; ?></h2></a>
	</div>
<?php endforeach; ?>
</div>
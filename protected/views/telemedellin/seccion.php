<?php 
$bc = array();
$bc[] = ucfirst($seccion->nombre);
$this->breadcrumbs = $bc;
$this->pageTitle = $seccion->nombre;

cs()->registerScriptFile( bu('js/jquery.mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js'), CClientScript::POS_END );
cs()->registerScript( 'scroll', 
	'$(".listado").mCustomScrollbar({
		scrollButtons:{
			enable:true
		}
	});',
	CClientScript::POS_READY
);


?>
<div id="seccion" class="<?php echo $seccion->url->slug; ?>">
	<div class="listado">
		<div class="buscadorProgramas">
		 	<FORM method=GET action="http://www.google.es/search"> 
			    <fieldset>                   
			        <INPUT TYPE=text id="s" name="q" value="Buscar programa" /> 
			    </fieldset> 
		    </FORM> 
		</div>
	<?php foreach($micrositios as $micrositio):?>
		<div <?php if($micrositio->destacado) echo 'class="destacado"'?>>
			<a href="<?php echo bu($micrositio->url->slug); ?>"><h2><?php echo $micrositio->nombre; ?></h2></a>
		</div>
	<?php endforeach; ?>
	</div>
	<div class="logos">
		<img src="http://localhost/tm/images/logos/altavoz.png" />
	</div>
</div>


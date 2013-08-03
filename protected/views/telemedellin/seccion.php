<<<<<<< HEAD

=======
<div id="contenedorInfo">
>>>>>>> be138ff52749e021b8952dcef5f7797084e2c6ad
<?php 
$bc = array();
$bc[] = ucfirst($seccion->nombre);
$this->breadcrumbs = $bc;
$this->pageTitle = $seccion->nombre;
/*cs()->registerScriptFile( bu('js/jquery.mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js'), CClientScript::POS_END );
cs()->registerScript( 'scroll', 
	'$(".listado").mCustomScrollbar({
		scrollButtons:{
			enable:true
		}
	});',
	CClientScript::POS_READY
);*/
?>

<div id="bgProgramas"><img src="http://localhost/tm/images/static/bgProgramas.png" /></div>

<div id="seccion" class="<?php echo $seccion->url->slug; ?>">
	<div class="buscadorProgramas">
	 	<form method="GET"> 
		    <fieldset>                   
		        <input TYPE="text" id="s" name="q" value="Buscar ..." /> 
		    </fieldset> 
	    </form> 
	</div>
	<div class="listado">
	<?php foreach($micrositios as $micrositio):?>
		<div <?php if($micrositio->destacado) echo 'class="destacado"'?>>
			<a href="<?php echo bu($micrositio->url->slug); ?>"><h2><?php echo $micrositio->nombre; ?></h2></a>
		</div>
	<?php endforeach; ?>
	</div>
<<<<<<< HEAD
=======
</div>
>>>>>>> be138ff52749e021b8952dcef5f7797084e2c6ad
</div>



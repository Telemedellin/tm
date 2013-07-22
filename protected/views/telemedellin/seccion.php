<?php 
$bc = array();
$bc[] = ucfirst($seccion->nombre);
$this->breadcrumbs = $bc;
$this->pageTitle = $seccion->nombre;
?>
<?php foreach($micrositios as $micrositio):?>
	<div <?php if($micrositio->destacado) echo 'class="destacado"'?> style="background: url('<?php echo bu() . $micrositio->background;?>') no-repeat center center; background-size: cover cover;">
		<h2><a href="<?php echo bu()?>/<?php echo $seccion->slug?>/<?php echo $micrositio->slug; ?>"><?php echo $micrositio->nombre; ?></a></h2>
	</div>
<?php endforeach; ?>
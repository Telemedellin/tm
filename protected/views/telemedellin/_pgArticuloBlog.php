<p><?php echo date('d M Y', $contenido['pagina']['creado'])  ?></p>
<p><?php echo $contenido['contenido']->entradilla ?></p>
<p>
	<img src="<?php echo bu() . '/' . $contenido['contenido']->imagen ?>" width="300" alt="<?php echo $contenido['pagina']['nombre'] ?>" />
	<?php echo $contenido['contenido']->texto ?>
</p>

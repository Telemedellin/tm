<a href="<?php echo bu($micrositio->url->slug) ?>/imagenes?m=<?php echo $micrositio->id ?>&ajax=true">Volver</a>
<h1>Galería <?php echo $album->nombre; ?>
<ul>
<?php foreach ($album->fotos as $foto): ?>
	<li>
		<img src="<?php echo bu('images/galeria/'.$foto->thumb) ?>" width="50" height="50" />
	</li>
<?php endforeach; ?>
</ul>
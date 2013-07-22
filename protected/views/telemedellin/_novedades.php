<?php foreach($novedades as $novedad): ?>
<div class="novedad">
	<a href="<?php echo bu() . '/novedades/' . $novedad['pagina']->slug ?>">
		<h3><?php echo $novedad['contenido']['titulo'] ?></h3>
		<p><?php echo date('d M Y', $novedad['pagina']->creado) ?></p>
		<p><?php echo $novedad['contenido']['entradilla'] ?></p>
		<p><img src="<?php echo bu() . '/' . $novedad['contenido']['imagen'] ?>" width="300" alt="<?php echo $novedad['contenido']['titulo'] ?>" /></p>
	</a>
</div>
 <?php endforeach ?>
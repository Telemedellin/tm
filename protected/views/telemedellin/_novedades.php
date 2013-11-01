<?php foreach($novedades as $novedad): ?>
<div class="novedad<?php if($novedad['pagina']->destacado) echo ' destacado'?>">
	<a href="<?php echo bu( $novedad['pagina']->url->slug ) ?>">
		<h3><?php echo $novedad['pagina']->nombre ?></h3>
		<p><?php echo date('d M Y', $novedad['pagina']->creado) ?></p>
		<p><?php echo $novedad['contenido']['entradilla'] ?></p>
		<p><img src="<?php echo bu('/' . $novedad['contenido']['imagen']) ?>" width="300" alt="<?php echo $novedad['pagina']->nombre ?>" /></p>
	</a>
</div>
 <?php endforeach ?>
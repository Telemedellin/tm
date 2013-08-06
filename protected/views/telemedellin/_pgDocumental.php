<h3>Sinopsis</h3>
<p><?php echo $contenido['contenido']->sinopsis ?></p>
<h3>Ficha Técnica</h3>
<p>Título: <?php echo $contenido['contenido']->titulo ?></p>
<p>Año: <?php echo $contenido['contenido']->anio ?></p>
<p>Duración: <?php echo $contenido['contenido']->duracion ?></p>
<?php foreach( $contenido['contenido']->fichaTecnicas as $item ): ?>
<p><?php echo $item->campo ?>: <?php echo $item->valor ?></p>
<?php endforeach ?>
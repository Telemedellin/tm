<?php $this->pageDesc = $contenido['contenido']->sinopsis;?>
<?php echo $contenido['contenido']->sinopsis ?>
<h3>Ficha Técnica</h3>
<p><b>Título:</b> <?php echo $contenido['contenido']->titulo ?></p>
<p><b>Año:</b> <?php echo $contenido['contenido']->anio ?></p>
<p><b>Duración:</b> <?php echo $contenido['contenido']->duracion ?> minutos</p>
<?php foreach( $contenido['contenido']->fichaTecnicas as $item ): ?>
<p><b><?php echo $item->campo ?>:</b> <?php echo $item->valor ?></p>
<?php endforeach ?>
<?php 
$this->pageDesc = ($contenido['pagina']->meta_descripcion != '')? $contenido['pagina']->meta_descripcion : '';
?>
<?php if(!empty($contenido['contenido']->bloques) && $bloques = $contenido['contenido']->bloques): ?>
<div class="row">
	<?php foreach( $bloques as $bloque ):?>
	<div class="span<?php echo $bloque->columnas ?>">
		<?php if($bloque->titulo): ?><h2><?php echo $bloque->titulo ?></h2><?php endif; ?>
		<?php echo $bloque->contenido ?>
	</div>
	<?php endforeach ?>
</div>
<?php endif; ?>
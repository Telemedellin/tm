<?php 
$this->pageDesc = ($contenido['pagina']->meta_descripcion != '')? $contenido['pagina']->meta_descripcion : '';
?>
<?php if(!empty($contenido['contenido']->bloques) && $bloques = $contenido['contenido']->bloques): ?>
<div class="row">
	<?php
	$nbloques = count($bloques);
	$columnas = 0;
	foreach( $bloques as $bloque ):?>
	<?php if($columnas == 0):?><div class="row-fluid"><?php endif ?>
	<?php $columnas += $bloque->columnas; ?>
	<div class="span<?php echo $bloque->columnas ?>">
		<?php if($bloque->titulo): ?><h2><?php echo $bloque->titulo ?></h2><?php endif; ?>
		<?php echo $bloque->contenido ?>
	</div>
	<?php if($columnas >= 12):?></div><?php $columnas = 0;endif; ?>
	<?php endforeach ?>
	<?php if($columnas != 0):?></div><?php endif; ?>
</div>
<?php endif; ?>
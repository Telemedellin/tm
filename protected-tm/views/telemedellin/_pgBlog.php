<?php 
$this->pageDesc = ($contenido['pagina']->meta_descripcion != '')? $contenido['pagina']->meta_descripcion : '';
setlocale(LC_ALL, 'es_ES.UTF-8');
?>
<?php if($articulos = $contenido['contenido']->articulos): ?>
	<?php $columnas = 0; ?>
	<?php foreach( $articulos as $articulo ): ?>
	<?php if($columnas == 0): ?><div class="row-fluid"><?php endif; $columnas += 3; ?>
	<div class="span3">
		<a href="<?php echo bu($articulo->url->slug) ?>">
			<div>
				<h2><?php echo $articulo->nombre ?></h2>
				<?php if($contenido['contenido']->ver_fechas):?>
					<time><?php echo ucfirst( strftime( '%B %e, %Y %l:%M %P', strtotime($articulo->creado) ) ); ?></time>
				<?php endif ?>
			</div>
			<figure>
				<img src="<?php echo bu('images/'.$articulo->miniatura) ?>" />
			</figure>
		</a>
	</div>
	<?php if($columnas >= 12):?></div><?php $columnas = 0;endif ?>
	<?php endforeach ?>
	<?php if($columnas != 0):?></div><?php endif ?>
<?php else: ?>
<p>Aún no hay artículos</p>
<?php endif; ?>
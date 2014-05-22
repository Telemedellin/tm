<?php 
$this->pageDesc = ($contenido['pagina']->meta_descripcion != '')? $contenido['pagina']->meta_descripcion : '';
?>
<?php if($articulos = $contenido['contenido']->articulos): ?>
<div class="row">
	<?php foreach( $articulos as $articulo ): $fecha = strtotime($articulo->creado);?>
	<div class="span3">
		<a href="<?php echo bu($articulo->url->slug) ?>">
			<div>
				<h2><?php echo $articulo->nombre ?></h2>
				<time><?php echo ucfirst(strftime('%B %e, %Y %l:%M %P', $fecha)); ?></time>
			</div>
			<img src="<?php echo bu('images/'.$articulo->pgArticuloBlogs->miniatura) ?>" />
		</a>
	</div>
	<?php endforeach ?>
</div>
<?php else: ?>
<p>Aún no hay artículos</p>
<?php endif; ?>
<h1>Álbumes <?php echo $micrositio->nombre; ?></h1>
<ul>
<?php foreach ($albumes as $album): ?>
	<?php if($album->fotos): ?>
	<li>
		<a href="<?php echo bu($album->url->slug); ?>" class="in_fancy">
			<img src="<?php echo bu('images/galeria/'.$album->fotos[0]->thumb) ?>" width="105" height="77" />
			<h2><?php echo $album->nombre ?></h2>
		</a>
	</li>
	<?php endif ?>
<?php endforeach; ?>
</ul>
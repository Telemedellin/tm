<div class="menu_micrositio">
<?php foreach($menu as $item): ?>
	<a href="<?php echo bu('programacion') . '?dia=' . date('d', $item) . '&mes=' . date('m', $item) . '&anio=' . date('Y', $item) ?>">
		<?php echo strftime("%A %d", $item); ?>
	</a>
<?php endforeach; ?>
</div>
<?php foreach($programas as $programa): ?>
<div class="programa">
	<a href="<?php echo bu() . '/programas/' . $programa->micrositio->slug ?>">
		<p><?php echo date('H:i A', $programa->hora_inicio) ?></p>
		<p><img src="<?php echo bu() . $programa->micrositio->background ?>" alt="<?php echo $programa->micrositio->nombre ?>" width="200" height="180" /></p>
		<p><?php echo $programa->micrositio->nombre ?></p>
	</a>
</div>
 <?php endforeach ?>
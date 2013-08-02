<div class="menu_micrositio">
<?php foreach($menu as $item): ?>
	<a href="<?php echo bu('programacion') . '?dia=' . date('d', $item) . '&mes=' . date('m', $item) . '&anio=' . date('Y', $item) ?>">
		<?php echo substr(strftime("%A", $item), 0, 3) ; ?> <?php echo strftime("%d", $item); ?>
	</a>
<?php endforeach; ?>
</div>
<div>
<?php foreach($programas as $programa): ?>
<div class="programa">
	<a href="<?php echo bu( $programa->micrositio->url->slug ); ?>">
		<div class="hora"><?php echo date('H:i A', $programa->hora_inicio) ?></div>

		<div class="tit_programa"><?php echo $programa->micrositio->nombre ?></div>
	</a>
</div>
 <?php endforeach ?>
</div>
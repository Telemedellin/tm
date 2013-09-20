<div class="menu_micrositio">
<?php $hoy = mktime(0, 0, 0, date('m'), date('d'), date('Y')); ?>
<?php foreach($menu as $item): ?>
	<a href="<?php echo bu('programacion') . '?dia=' . date('d', $item) . '&mes=' . date('m', $item) . '&anio=' . date('Y', $item) ?>" <?php echo ($item >= $hoy && $item < ($hoy+86400) ) ? 'class="hoy"':''?>>
		<?php echo strftime("%A", $item); ?> <?php echo strftime("%d", $item); ?>
	</a>
<?php endforeach; ?>
</div>
<div>
<?php foreach($programas as $programa): ?>
<div class="programa <?php echo (time() >= $programa->hora_inicio && time() <= $programa->hora_fin)? 'actual':''?>">
	<a href="<?php echo bu( $programa->micrositio->url->slug ); ?>">
		<div class="hora"><?php echo date('H:i a', $programa->hora_inicio) ?></div>
		<div class="tit_programa"><?php echo $programa->micrositio->nombre ?></div>
	</a>
</div>
 <?php endforeach ?>
</div>
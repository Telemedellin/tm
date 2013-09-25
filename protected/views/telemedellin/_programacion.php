<?php $this->pageTitle = 'Programación' ?>
<div class="menu_micrositio">
<?php $hoy = mktime(0, 0, 0, date('m'), date('d'), date('Y')); ?>
<?php foreach($menu as $item): ?>
	<?php $url = bu('programacion') . '?dia=' . date('d', $item) . '&mes=' . date('m', $item) . '&anio=' . date('Y', $item); ?>
	<a href="<?php echo $url ?>" class="<?php echo ( ($item >= $hoy && $item < ($hoy+86400)) ) ? 'hoy':''?> <?php echo ( $url == Yii::app()->request->requestUri ) ? 'elegido':''?>">
		<?php echo strftime("%A", $item); ?> <?php echo strftime("%d", $item); ?>
	</a>
<?php endforeach; ?>
</div>
<div class="listado_programas">
<?php foreach($programas as $programa): ?>
<?php $actual = false; if(time() >= $programa->hora_inicio && time() <= $programa->hora_fin) $actual = true;?>
<div class="programa <?php if($actual) echo 'actual'; ?>">
	<a href="<?php if($actual) echo bu('senal-en-vivo'); else echo bu( $programa->micrositio->url->slug ); ?>">
		<div class="hora"><?php echo date('h:i a', $programa->hora_inicio) ?></div>
		<div class="tit_programa"><?php echo $programa->micrositio->nombre ?></div>
	</a>
</div>
 <?php endforeach ?>
</div>


<?php $this->pageTitle = 'Programación' ?>
<div class="menu_micrositio">
<?php echo ProgramacionW::getMenu($menu); ?>
</div>
<div class="listado_programas">
<?php foreach($programas as $programa): ?>
<?php $actual = false; if(time() >= $programa->hora_inicio && time() <= $programa->hora_fin) $actual = true;?>
<div class="programa <?php if($actual) echo 'actual'; ?>">
	<?php if($programa->micrositio->estado == 1 || $actual): ?>
		<a href="<?php if($actual) echo bu('senal-en-vivo'); else echo bu( $programa->micrositio->url->slug ); ?>">
	<?php else: ?>
		<span>
	<?php endif ?>
			<div class="hora"><time><?php echo date('h:i a', $programa->hora_inicio) ?></time></div>
			<div class="tit_programa"><?php echo $programa->micrositio->nombre ?></div>
	<?php if($programa->micrositio->estado == 1): ?>
		</a>
	<?php else: ?>
		</span>
	<?php endif; ?>
</div>
<?php endforeach ?>
</div>


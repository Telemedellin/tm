<?php $this->pageTitle = 'Programación' ?>
<div class="menu_micrositio">
<?php echo ProgramacionW::getMenu($menu); ?>
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


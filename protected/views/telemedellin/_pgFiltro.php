<?php $this->pageDesc = $contenido['contenido']->descripcion;?>
<?php echo $contenido['contenido']->descripcion ?>
<div class="filtro"> 
    <input type="text" id="txtFiltro" name="txtFiltro" placeholder="Filtrar..." />
</div>
<?php if($items = $contenido['contenido']->filtroItems): ?>
<div class="listado">
	<ul class="inner nivel-1">
	<?php 
	foreach( $items as $item ): 
	if($item->padre == 0): ?>
	<li><span><?php echo $item->elemento ?></span>
		<?php if($item->hijos): ?>
			<ul class="nivel-2">
				<?php foreach($items as $hijo): ?>
				<?php if($hijo->padre == $item->id): ?>
				<li class="filtrable"><span><?php echo $hijo->elemento ?></span>
					<?php if($hijo->hijos): ?>
						<ul class="nivel-3">
							<?php foreach($items as $nieto): ?>
							<?php if($nieto->padre == $hijo->id): ?>
							<li><?php 
								$e = explode(' ', $nieto->elemento);
								for($i = 0; $i < count($e); $i++){
									if(($i+1) == count($e)) echo '<span>';
									echo $e[$i] . ' ';
									if(($i+1) == count($e)) echo '</span>';
								}
								?></li>
							<?php endif; ?>
							<? endforeach; ?>
						</ul>
					<?php endif; ?>
				</li>
				<?php endif; ?>
				<? endforeach; ?>
			</ul>
		<?php endif; ?>
	</li>
	<?php endif; ?>
	<?php endforeach ?>
	</ul>
</div>
<?php endif; ?>
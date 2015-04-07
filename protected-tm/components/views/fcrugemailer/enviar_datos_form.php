<div><strong>Usuario: </strong> <?php echo $usuario->nombres . ' ' . $usuario->apellidos ?></div>
<?php foreach( $datos as $k => $dato ): ?>
<div><strong><?php echo $k ?>:</strong> 
	<?php if( is_array($dato) ): ?>
		<?php foreach( $dato as $d): ?>
			<?php $df = $d; ?>
		<?php endforeach ?>
	<?php else: ?>
		<?php $df = $dato; ?>
	<?php endif; ?>
	<?php if( strpos($df, '/uploads/') !== false ) $df = '<a href="'.$this->createAbsoluteUrl($df).'">'. $df .'</a>'; ?>
	<p><?php echo $df ?></p>
</div>
<?php endforeach ?>
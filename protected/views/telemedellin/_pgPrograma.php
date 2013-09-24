<?php if($contenido['contenido']->estado == 2):?>
<p>
	<strong>
		<?php echo Horarios::horario_parser( $contenido['contenido']->horario ); ?>
	</strong>
</p>
<?php endif; ?>
<p><?php echo $contenido['contenido']->resena ?></p>
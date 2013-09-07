<?php if($contenido['contenido']->estado == 2):?>
<p>
	<strong>
		<?php echo Horarios::horario_programa( $contenido['contenido']->horario ); ?>
	</strong>
</p>
<?php endif; ?>
<h3>Reseña</h3>
<p><?php echo $contenido['contenido']->resena ?></p>
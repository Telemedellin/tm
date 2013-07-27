<?php if($contenido['contenido']->estado == 2):?>
<p>
	<strong>
		<?php echo Horarios::horario_programa( $contenido['contenido']->horario ); ?>
	</strong>
</p>
<?php endif; ?>
<h3>Reseña</h3>
<p><?php echo $contenido['contenido']->resena ?></p>

<?php if( $contenido['contenido']->esta_semana ): ?>
	<h3>Esta semana</h3>
<?php 
	echo $contenido['contenido']->esta_semana;
?>
<?php endif; ?>
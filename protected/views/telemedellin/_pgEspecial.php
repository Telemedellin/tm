<h3>Reseña</h3>
<p><?php echo $contenido['contenido']->resena ?></p>
<?php if( !is_null($contenido['contenido']->fechaEspecials) ): ?>
<p>Fecha: <?php echo Horarios::fecha_especial( $contenido['contenido']->fechaEspecials ); ?></p>
<?php endif ?>
<?php if( !is_null($contenido['contenido']->lugar) ): ?>
<p>Lugar: <?php echo $contenido['contenido']->lugar ?></p>
<?php endif ?>
<?php if( !is_null($contenido['contenido']->presentadores) ): ?>
<p>Presentadores: <?php echo $contenido['contenido']->presentadores ?></p>
<?php endif ?>
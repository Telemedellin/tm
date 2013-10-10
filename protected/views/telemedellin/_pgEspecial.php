<?php if( !is_null($contenido['contenido']->fechaEspecials) ): ?>
<p><b>Fecha:</b> <?php echo Horarios::fecha_especial( $contenido['contenido']->fechaEspecials ); ?></p>
<?php endif ?>
<p><?php echo $contenido['contenido']->resena ?></p>
<?php if( !is_null($contenido['contenido']->lugar) ): ?>
<p><b>Lugar:</b> <?php echo $contenido['contenido']->lugar ?></p>
<?php endif ?>
<?php if( !is_null($contenido['contenido']->presentadores) ): ?>
<p><b>Presentadores:</b> <?php echo $contenido['contenido']->presentadores ?></p>
<?php endif ?>
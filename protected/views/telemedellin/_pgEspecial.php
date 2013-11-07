<?php if( count($contenido['contenido']->fechaEspecials) ): ?>
<p><b>Fecha:</b> <?php echo Horarios::fecha_especial( $contenido['contenido']->fechaEspecials ); ?></p>
<?php endif ?>
<p><?php echo $contenido['contenido']->resena ?></p>
<?php if( $contenido['contenido']->lugar != '' ): ?>
<p><b>Lugar:</b> <?php echo $contenido['contenido']->lugar ?></p>
<?php endif ?>
<?php if( $contenido['contenido']->presentadores != '' ): ?>
<p><b>Presentadores:</b> <?php echo $contenido['contenido']->presentadores ?></p>
<?php endif ?>
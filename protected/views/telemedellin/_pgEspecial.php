<?php 
$this->pageDesc = ($contenido['pagina']->meta_descripcion != '')? $contenido['pagina']->meta_descripcion : $contenido['contenido']->resena;
if( count($contenido['contenido']->fechaEspecials) ): 
?>
<p><b>Fecha:</b> <?php echo Horarios::fecha_especial( $contenido['contenido']->fechaEspecials ); ?></p>
<?php endif ?>
<?php echo $contenido['contenido']->resena ?>
<?php if( $contenido['contenido']->lugar != '' ): ?>
<p><b>Lugar:</b> <?php echo $contenido['contenido']->lugar ?></p>
<?php endif ?>
<?php if( $contenido['contenido']->presentadores != '' ): ?>
<p><b>Presentadores:</b> <?php echo $contenido['contenido']->presentadores ?></p>
<?php endif ?>
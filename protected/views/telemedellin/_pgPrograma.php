<?php $this->pageDesc = $contenido['contenido']->resena;?>
<?php if($contenido['contenido']->estado == 2 && !empty($contenido['contenido']->horario) ):?>
<p>
	<strong class="horario-emision">
		<?php echo Horarios::horario_parser( $contenido['contenido']->horario ); ?>
	</strong>
</p>
<?php endif; ?>
<?php echo $contenido['contenido']->resena ?>
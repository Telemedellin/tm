<?php
if( !empty($contenido['contenido']->miniatura) )
cs()->registerCss('background', 'body{background-image: url("' . bu('/images/' . $contenido['contenido']->imagen) . '");}');
?>
<p><?php echo date('d M Y', strtotime($contenido['pagina']['creado']) ) ?></p>
<p><img src="<?php echo bu('/images/' . $contenido['contenido']->miniatura) ?>" width="50" alt="<?php echo $contenido['pagina']['nombre'] ?>" /></p>
<p><?php echo $contenido['contenido']->entradilla ?></p>
<p><?php echo $contenido['contenido']->texto ?></p>

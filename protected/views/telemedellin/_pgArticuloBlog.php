<?php
$this->pageDesc = $contenido['contenido']->entradilla;
if( !empty($contenido['contenido']->imagen) )
cs()->registerCss('background', 'body{background-image: url("' . bu('/images/' . $contenido['contenido']->imagen) . '");}');
?>
<p><strong><?php echo date('d M Y', strtotime($contenido['pagina']['creado']) ) ?></strong></p>
<!--<p><img src="<?php echo bu('/images/' . $contenido['contenido']->miniatura) ?>" width="50" alt="<?php echo $contenido['pagina']['nombre'] ?>" /></p>-->
<p><?php echo $contenido['contenido']->texto ?></p>

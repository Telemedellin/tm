<?php
$this->pageDesc = $contenido['contenido']->entradilla;
if( !empty($contenido['contenido']->imagen) )
cs()->registerCss('background', 'body{background-image: url("' . bu('/images/' . $contenido['contenido']->imagen) . '");}');
?>
<?php echo $contenido['contenido']->texto ?>

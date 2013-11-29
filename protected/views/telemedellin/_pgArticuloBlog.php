<?php
$this->pageDesc = $contenido['contenido']->entradilla;
if( !empty($contenido['contenido']->imagen) )
cs()->registerCss('background', 'body{background-image: url("' . bu('/images/' . $contenido['contenido']->imagen) . '");}');
?>
<p><time datetime="<?php echo date('Y-m-d H:i', strtotime($contenido['pagina']['creado']))?>"><?php echo date('d M Y', strtotime($contenido['pagina']['creado']) ) ?></time></p>
<?php echo $contenido['contenido']->texto ?>

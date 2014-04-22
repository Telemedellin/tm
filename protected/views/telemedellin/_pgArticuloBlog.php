<?php
$this->pageDesc = ($contenido['pagina']->meta_descripcion != '')? $contenido['pagina']->meta_descripcion : $contenido['contenido']->entradilla;
if( !empty($contenido['contenido']->imagen) )
cs()->registerCss('background', 'body{background-image: url("' . bu('/images/' . $contenido['contenido']->imagen) . '");}');
echo $contenido['contenido']->texto 
?>

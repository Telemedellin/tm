<?php 
$this->pageDesc = ($contenido['pagina']->meta_descripcion != '')? $contenido['pagina']->meta_descripcion : $contenido['contenido']->texto;
echo $contenido['contenido']->texto 
?>
<?php
$bc = array();
$bc[] = 'Resultados de búsqueda para el término "' . $termino . '"';
$this->breadcrumbs = $bc;
$this->pageTitle = 'Resultados de búsqueda para el término "' . $termino . '"';
?>
<div id="seccion" class="resultados_busqueda">
	<?php print_r($termino) ?>
</div>
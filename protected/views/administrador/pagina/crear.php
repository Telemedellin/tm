<?php
/* @var $this PaginaController */
/* @var $model Pagina */

$this->breadcrumbs=array(
	'Paginas'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Listar Páginas', 'url'=>array('index')),
	array('label'=>'Manage Pagina', 'url'=>array('admin')),
);
?>

<h1>Crear Página</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this PaginaController */
/* @var $model Pagina */

$this->breadcrumbs=array(
	'Paginas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Pagina', 'url'=>array('index')),
	array('label'=>'Manage Pagina', 'url'=>array('admin')),
);
?>

<h1>Create Pagina</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
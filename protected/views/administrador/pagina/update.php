<?php
/* @var $this PaginaController */
/* @var $model Pagina */

$this->breadcrumbs=array(
	'Paginas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Listar Páginas', 'url'=>array('index')),
	array('label'=>'Crear Página', 'url'=>array('crear')),
	array('label'=>'Ver Página', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Pagina', 'url'=>array('admin')),
);
?>

<h1>Actualizar Página <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
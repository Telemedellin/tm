<?php
/* @var $this UrlController */
/* @var $model Url */

$this->breadcrumbs=array(
	'Urls'=>array('index'),
	'Crear',
);

$this->menu=array(
	array('label'=>'List Url', 'url'=>array('index')),
	array('label'=>'Manage Url', 'url'=>array('admin')),
);
?>

<h1>Crear Url</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php
/* @var $this PgGenericaStController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Pg Generica Sts',
);

$this->menu=array(
	array('label'=>'Create PgGenericaSt', 'url'=>array('create')),
	array('label'=>'Manage PgGenericaSt', 'url'=>array('admin')),
);
?>

<h1>Pg Generica Sts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

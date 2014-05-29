<?php
/* @var $this PgGenericaStController */
/* @var $model PgGenericaSt */

$this->breadcrumbs=array(
	'Pg Generica Sts'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List PgGenericaSt', 'url'=>array('index')),
	array('label'=>'Create PgGenericaSt', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#pg-generica-st-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Pg Generica Sts</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pg-generica-st-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'pagina_id',
		'texto',
		'estado',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

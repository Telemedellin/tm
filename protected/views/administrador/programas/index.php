<?php
/* @var $this UrlController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Programas',
);
?>

<h1>Programas</h1>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . ' alert-success">' . $message . "</div>\n";
    }
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'enableSorting' => true,
    'pager' => array('pageSize' => 25),
	'columns'=>array(
        'id',
        'nombre',
        'creado',
        'modificado',
        'estado',
        'destacado',
        array(
            'class'=>'CButtonColumn',
        ),
    )
)); ?>

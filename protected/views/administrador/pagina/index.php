<h1>Páginas</h1>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . ' alert-success">' . $message . "</div>\n";
    }
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'enableSorting' => true,
	'columns'=>array(
        array(
            'name'=>'Nombre',
            'value'=>'l($data->nombre, bu($data->url->slug) )',
            'type'=>'html'
        ),
        array(
            'name'=>'Micrositio',
            'value'=>'l($data->micrositio->nombre, bu($data->micrositio->url->slug) )',
            'type'=>'html'
        ),
        array(
            'name'=>'Tipo de página',
            'value'=>'$data->tipoPagina->nombre',
        ),
        array(
            'name'=>'creado',
            'value'=>'date("Y-m-d H:i:s", $data->creado)',
        ),
        array(
            'name'=>'modificado',
            'value'=>'date("Y-m-d H:i:s", $data->modificado)',
        ),
        'estado',
        'destacado',
        array(
            'class'=>'CButtonColumn',
        ),
    )
)); ?>
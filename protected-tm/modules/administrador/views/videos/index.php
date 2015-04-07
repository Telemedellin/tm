<?php $this->pageTitle = 'Videos'; ?>
<h1>Videos</h1>
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
        array(
            'name' => 'nombre', 
            'type' => 'raw', 
            'value' => 'l($data->nombre, bu($data->url->slug), array("target" => "_blank"))',
        ),
        array(
            'name' => 'albumVideo.nombre', 
            'header' => 'Álbum'
        ),
        array(
            'name' => 'proveedorVideo.nombre', 
            'type' => 'raw', 
            'value' => 'l($data->proveedorVideo->nombre, $data->url_video, array("target" => "_blank"))',
        ),
        'creado',
        'modificado',
        array(
            'name'=>'estado',
            'header'=>'Publicado',
            'filter'=>array('1'=>'Si','0'=>'No'),
            'value'=>'($data->estado=="1")?("Si"):("No")'
        ),
        array(
            'name'=>'destacado',
            'filter'=>array('1'=>'Si','0'=>'No'),
            'value'=>'($data->destacado=="1")?("Si"):("No")'
        ),
        array(
            'class'=>'CButtonColumn',
        ),
    )
)); ?>

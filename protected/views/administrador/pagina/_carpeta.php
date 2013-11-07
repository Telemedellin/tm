<?php 
//print_r($contenido['contenido']);
$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=> new CActiveDataProvider($contenido['contenido'], array('criteria' => array('condition'=>'item_id = 0') )),
	'enableSorting' => true,
	'columns'=>array(
        'id',
        array(
            'name'=>'url.slug',
            'value'=>'l($data->url->slug, bu("'.$contenido['pagina']->micrositio->url->slug.'". $data->url->slug) )',
            'type'=>'raw'
        ),
        'carpeta',
        'ruta',
        'estado',
        /*array(
            'class'=>'CButtonColumn',
        ),*/
    )
));
/*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$contenido['contenido'],
	'attributes'=>array(
		'id',
		array(
			'name' => 'url.slug', 
			'type' => 'raw', 
			'value' => l($contenido['contenido']->url->slug, bu($contenido['pagina']->micrositio->url->slug . $contenido['contenido']->url->slug), array('target' => '_blank')),
		),
		'carpeta',
		'ruta',
		array(
			'name' => 'estado',
			'value' => ($contenido['contenido']->estado==1)?'Si':'No',
		)
	),
)); */?>
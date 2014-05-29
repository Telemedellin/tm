<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$contenido['contenido'],
	'attributes'=>array(
		'texto:html', 
		'comentarios', 
		array(
			'name' => 'miniatura', 
			'type' => 'raw', 
			'value' => l($contenido['contenido']->miniatura, bu('images/'.$contenido['contenido']->miniatura), array('target' => '_blank')),
		),
		'estado',
	),
)); ?>
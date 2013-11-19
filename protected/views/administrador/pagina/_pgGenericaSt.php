<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$contenido['contenido'],
	'attributes'=>array(
		'texto:html', 
		array(
			'name' => 'imagen', 
			'type' => 'raw', 
			'value' => l($contenido['contenido']->imagen, bu('images/'.$contenido['contenido']->imagen), array('target' => '_blank')),
		),
		array(
			'name' => 'miniatura', 
			'type' => 'raw', 
			'value' => l($contenido['contenido']->miniatura, bu('images/'.$contenido['contenido']->miniatura), array('target' => '_blank')),
		),
	),
)); ?>
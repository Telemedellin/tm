<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$contenido['contenido'],
	'attributes'=>array(
		'titulo', 
		'duracion', 
		'anio', 
		'sinopsis:html', 
	),
)); ?>
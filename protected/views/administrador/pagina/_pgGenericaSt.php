<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$contenido['contenido'],
	'attributes'=>array(
		'id',
		'texto:html',
		array(
			'name' => 'estado',
			'value' => ($contenido['contenido']->estado==1)?'Si':'No',
		)
	),
)); ?>
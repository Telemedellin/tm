<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$contenido['contenido'],
	'attributes'=>array(
		'formulario_id', 
		array(
			'name' => 'formulario_id', 
			'label' => 'Editar en JotForm',
			'type' => 'raw', 
			'value' => l('<i class="fa fa-external-link"></i> http://spanish.jotform.com//?formID=' .$contenido['contenido']->formulario_id, 'http://spanish.jotform.com//?formID='.$contenido['contenido']->formulario_id, array('target' => '_blank')),
		),
	),
)); ?>
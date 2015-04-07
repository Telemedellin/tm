<?php
$bc = array();
$bc['Usuario'] = bu('usuario');
$bc[] = 'Hasta la próxima';
$this->breadcrumbs = $bc;
if($fondo_pagina == NULL)
	cs()->registerCss('background', 'body{background-image: none}');
else{
	$bg = bu('/images/' . $fondo_pagina);
	cs()->registerCss('background', 'body{background-image: url("' . $bg . '");}');
}
$this->pageTitle = 'Hasta la próxima';
$this->pageDesc = 'Canal público cultural de la ciudad de Medellín. Programación, noticias, horarios.';
?>
<div id="micrositio" class="especiales">
	<div class="contenidoScroll">
	<h2>¡Esperamos que vuelvas!</h2>
	<p>La cuenta con toda tu información fue borrada exitosamente de nuestra base de datos.</p>
	<p>Lamentamos que ya no quieras estar en contacto con nosotros por este medio, sin embargo nos gustaría saber cuál fue tu motivo para tenerlo presente en futuras oportunidades:</p>
	<?php foreach(Yii::app()->user->getFlashes() as $key => $message): ?>
		<div class="alert alert-block alert-<?php echo $key ?>"><?php echo $message ?></div>
	<?php endforeach ?>
	<?php
	$form = $this->beginWidget('CActiveForm', array(
	    'id'=>'borrar-cuenta',
	    'errorMessageCssClass' => 'alert alert-error', 
	    'htmlOptions' => array(
	    	'class' => 'form-horizontal',
	    ),
	)); ?>
	<div class="control-group">
		<div class="controls">
			<?php echo CHtml::radioButtonList('motivo', '', 
					array(
						'Novedades' => 'No me interesaban las novedades de Telemedellín',
						'Correos' => 'No quería seguir recibiendo correos electrónicos de Telemedellín',
						'Molestia' => 'Recibía con mucha frecuencia información de Telemedellín y eso me molestaba.',
						'Intereses' => 'La información, contenidos, novedades, concursos no van acordes a mis intereses.',
						'Términos' => 'No estoy de acuerdo con los términos y condiciones',
						'Expectativas' => 'El servicio no llenó mis expectativas',
						'Todas' => 'Todas las anteriores',
						'Otro' => 'Otro'
						)
				); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<?php echo CHtml::textField('otro_motivo'); ?>
		</div>
	</div>
	<div class="row buttons">
		<?php echo CHtml::hiddenField('baja_id', $baja_id); ?>
		<?php echo CHtml::submitButton("Enviar"); ?>
	</div>
	<?php $this->endWidget(); ?>
	<div class="hidden">
		<img src="<?php echo $bg ?>" width="1500" />
	</div>
	</div>
</div>
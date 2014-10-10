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
	<h2>¡Hasta la próxima!</h2>
	<p>Tu cuenta con toda tu información ha sido borrada asfnajksfnhasdhfñasdf asdbfl bsdvb hjdvblasdbvl.</p>
	<p>asdasfasd fasdf asdf asdf asdf sdfsdfef af e copien los #$"%&%&/$%#" textos que me da pereza transcribir de las imágenes.</p>
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
						'Beneficios' => 'No me interesan los beneficios de Telemedellín',
						'Correos' => 'No quería seguir recibiendo correos electrónicos de Telemedellín', 
						'Términos' => 'No estoy de acuerdo con los términos y condiciones', 
						'Expectativas' => 'El servicio no llenó mis expectativas',
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
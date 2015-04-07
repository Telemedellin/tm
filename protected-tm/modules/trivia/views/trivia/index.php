<?php
$bc = array();
$bc[] = 'Trivia';
$this->breadcrumbs = $bc;
if($fondo_pagina == NULL)
	cs()->registerCss('background', 'body{background-image: none}');
else{
	$bg = bu('/images/' . $fondo_pagina);
	cs()->registerCss('background', 'body{background-image: url("' . $bg . '");}');
}
$this->pageTitle = 'Trivia';
$this->pageDesc = 'Canal público cultural de la ciudad de Medellín. Programación, noticias, horarios.';
?>
<div id="micrositio" class="especiales">
	<div class="contenidoScroll">
		<div id="trivia-content">
			<div id="mensaje">
				<div></div>
				<a href="#" class=""></a>
			</div>
			<?php 
				$form = $this->beginWidget('CActiveForm', 
					array('id'=>'trivia-form',)
				); 
			?>
			<div id="pregunta">
				<p>Podrás sumar puntos adicionales a través de esta trivia semanal.</p>
				<p>La trivia se activará todos los lunes a las 8 A.M. y estará vigente para participara una vez a la semana hasta el lunes a las 7:59 A.</p>
				<p id="p" class="pregunta"><?php echo $pregunta->pregunta ?></p>
				<div class="form-control">
				<?php echo $form->radioButtonList($model, 'respuesta', $respuestas); ?>
				</div>
				<div>
					<?php echo $form->hiddenField($model, 'pregunta', array('value' => $pregunta->id) ); ?>
					<?php echo CHtml::submitButton('Participar'); ?>
				</div>
			</div>
			<?php $this->endWidget(); ?>
		</div>
	<div class="hidden">
		<img src="<?php echo $bg ?>" width="1500" />
	</div>
	</div>
</div>
<?php
$bc = array();
$bc['Usuario'] = bu('usuario');
$bc[] = 'Ingresar';
$this->breadcrumbs = $bc;
if($fondo_pagina == NULL)
	cs()->registerCss('background', 'body{background-image: none}');
else{
	$bg = bu('/images/' . $fondo_pagina);
	cs()->registerCss('background', 'body{background-image: url("' . $bg . '");}');
}
$this->pageTitle= 'Ingresar - ' . Yii::app()->name;
?>
<div id="micrositio" class="especiales">
	<div class="contenidoScroll">
		<h1>Iniciar sesión</h1>
		<?php if(Yii::app()->user->hasFlash('loginflash')): ?>
		<div class="flash-error">
			<?php echo Yii::app()->user->getFlash('loginflash'); ?>
		</div>
		<?php endif ?>
		<?php $this->renderPartial('_login_form', array('model' => $model)); ?>
		<div class="hidden">
			<img src="<?php echo $bg ?>" width="1500" />
		</div>
	</div>
</div>
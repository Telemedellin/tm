<?php
$this->pageTitle = 'Crear micrositio'; 
$bc = array();
$bc['Telemedellín'] = bu('/administrador/telemedellin');
$bc[] = 'Crear';
$this->breadcrumbs = $bc;
?>

<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
</div>
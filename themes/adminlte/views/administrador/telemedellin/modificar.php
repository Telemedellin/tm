<?php 
$this->pageTitle = 'Modificar micrositio "' . $model->nombre. '"'; 
$bc = array();
$bc['Telemedellín'] = bu('/administrador/telemedellin');
$bc['Micrositio'] = bu('/administrador/telemedellin/view/'.$model->id);
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>

<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
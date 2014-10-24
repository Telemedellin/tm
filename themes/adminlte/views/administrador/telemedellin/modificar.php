<?php 
$this->pageTitle = 'Modificar micrositio "' . $model->nombre. '"'; 
$bc = array();
$bc['Telemedellín'] = $this->createUrl('index');
$bc['Micrositio'] = $this->createUrl('view', array('id' => $model->id));
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>

<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
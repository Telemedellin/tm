<?php 
$this->pageTitle = 'Crear concurso'; 
$bc = array();
$bc['Concursos'] = bu('/administrador/concursos');
$bc[] = 'Crear';
$this->breadcrumbs = $bc;
?>

<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
</div>
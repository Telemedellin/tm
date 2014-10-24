<?php 
$this->pageTitle = 'Modificar concurso "' . $model->nombre. '"'; 
$bc = array();
$bc['Concursos'] = $this->createUrl('index');
$bc['Concurso'] = $this->createUrl('view', array('id' => $model->id));
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
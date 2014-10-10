<?php 
$this->pageTitle = 'Modificar concurso "' . $model->nombre. '"'; 
$bc = array();
$bc['Concursos'] = bu('/administrador/concursos');
$bc['Concurso'] = bu('/administrador/concursos/view/'.$model->id);
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
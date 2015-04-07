<?php 
$this->pageTitle = 'Modificar evento "' . $model->nombre. '"'; 
$bc = array();
$bc['Padre'] = $this->createUrl('pagina/view', array('id' => $model->pgEventos->pagina->id));
$bc['Evento'] = $this->createUrl('view', array('id' => $model->id));
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
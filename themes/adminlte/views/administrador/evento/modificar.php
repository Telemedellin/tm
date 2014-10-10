<?php 
$this->pageTitle = 'Modificar evento "' . $model->nombre. '"'; 
$bc = array();
$bc['Padre'] = bu('/administrador/pagina/view/'.$model->pgEventos->pagina->id);
$bc['Evento'] = bu('/administrador/evento/view/'.$model->id);
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
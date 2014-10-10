<?php 
$this->pageTitle = 'Modificar menú "' . $model->nombre. '"'; 
$bc = array();
$bc['Padre'] = bu('/administrador/'.lcfirst($model->micrositios[0]->seccion->nombre).'/view/'.$model->micrositios[0]->id);
$bc['Página'] = bu('/administrador/pagina/view/'.$model->id);
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>

<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
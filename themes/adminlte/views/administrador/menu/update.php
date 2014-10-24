<?php 
$this->pageTitle = 'Modificar menú "' . $model->nombre. '"'; 
$bc = array();
$bc['Padre'] = $this->createUrl(lcfirst($model->micrositios[0]->seccion->nombre).'/view', array('id' => $model->micrositios[0]->id));
$bc['Página'] = $this->createUrl('pagina/view', array('id' => $model->id));
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>

<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
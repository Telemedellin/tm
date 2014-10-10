<?php 
$this->pageTitle = 'Modificar red social ' . $model->tipoRedSocial->nombre . ' ' . $model->usuario; 
$bc = array();
$bc['Padre'] = bu('/administrador/'.strtolower($model->micrositio->seccion->nombre).'/view/'.$model->micrositio->id);
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
<?php 
$this->pageTitle = 'Modificar página "' . $model->nombre. '"'; 
$bc = array();
$bc['Padre'] = $this->createUrl(lcfirst($this->slugger($model->micrositio->seccion->nombre)).'/view', array('id' => $model->micrositio->id));
$bc['Página'] = $this->createUrl('view', array('id' => $model->id));
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>

<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model' => $model, 'partial' => $partial, 'contenido' => $contenido)); ?>
</div>
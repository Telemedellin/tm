<?php 
$this->pageTitle = 'Modificar página "' . $model->nombre. '"'; 
$bc = array();
$bc['Padre'] = bu('/administrador/'.lcfirst($model->micrositio->seccion->nombre).'/view/'.$model->micrositio->id);
$bc['Página'] = bu('/administrador/pagina/view/'.$model->id);
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>

<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model' => $model, 'partial' => $partial, 'contenido' => $contenido)); ?>
</div>
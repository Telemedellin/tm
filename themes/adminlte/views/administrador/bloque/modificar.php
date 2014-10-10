<?php 
$this->pageTitle = 'Modificar bloque "' . $model->titulo. '"'; 
$bc = array();
$bc['Padre'] = bu('/administrador/pagina/view/'.$model->pgBloques->pagina->id);
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
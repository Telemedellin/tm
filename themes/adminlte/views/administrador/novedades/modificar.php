<?php 
$this->pageTitle = 'Modificar novedad "' . $model->nombre. '"'; 
$bc = array();
$bc['Novedades'] = bu('/administrador/novedades');
$bc['Novedad'] = bu('/administrador/novedades/view/'.$model->id);
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
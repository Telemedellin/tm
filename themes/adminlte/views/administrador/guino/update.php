<?php 
$this->pageTitle = 'Modificar guiño "' . $model->nombre. '"'; 
$bc = array();
$bc['Guiños'] = bu('/administrador/guino');
$bc['Guiño'] = bu('/administrador/guino/view/'.$model->id);
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
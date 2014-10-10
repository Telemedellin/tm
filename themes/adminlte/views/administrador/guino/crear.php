<?php 
$this->pageTitle = 'Crear guiño'; 
$bc = array();
$bc['Guiños'] = bu('/administrador/guino');
$bc[] = 'Crear';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
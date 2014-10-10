<?php 
$this->pageTitle = 'Crear video'; 
$bc = array();
$bc['Videos'] = bu('/administrador/videos');
$bc[] = 'Crear';
$this->breadcrumbs = $bc;
?>

<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
</div>
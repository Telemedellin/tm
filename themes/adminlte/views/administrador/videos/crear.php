<?php 
$this->pageTitle = 'Crear video'; 
$bc = array();
$bc['Videos'] = $this->createUrl('index');
$bc[] = 'Crear';
$this->breadcrumbs = $bc;
?>

<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
</div>
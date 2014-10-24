<?php 
$this->pageTitle = 'Modificar video "' . $model->nombre. '"'; 
$bc = array();
$bc['Videos'] = $this->createUrl('index');
$bc['Video'] = $this->createUrl('view', array('id' => $model->id));
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>

<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
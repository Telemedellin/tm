<?php 
$this->pageTitle = 'Modificar guiño "' . $model->nombre. '"'; 
$bc = array();
$bc['Guiños'] = $this->createUrl('index');
$bc['Guiño'] = $this->createUrl('view', array('id' => $model->id));
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
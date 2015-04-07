<?php 
$this->pageTitle = 'Modificar especial "' . $model->nombre. '"'; 
$bc = array();
$bc['Especiales'] = $this->createUrl('index');
$bc['Especial'] = $this->createUrl('view', array('id' => $model->id));
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
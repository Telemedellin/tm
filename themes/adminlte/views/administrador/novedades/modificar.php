<?php 
$this->pageTitle = 'Modificar novedad "' . $model->nombre. '"'; 
$bc = array();
$bc['Novedades'] = $this->createUrl('index');
$bc['Novedad'] = $this->createUrl('view', array('id' => $model->id));
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
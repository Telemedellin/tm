<?php 
$this->pageTitle = 'Modificar video "' . $model->nombre. '"'; 
$bc = array();
$bc['Videos'] = bu('/administrador/videos');
$bc['Video'] = bu('/administrador/videos/view/'.$model->id);
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>

<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
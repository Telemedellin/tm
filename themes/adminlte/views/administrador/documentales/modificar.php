<?php 
$this->pageTitle = 'Modificar documental "' . $model->nombre. '"'; 
$bc = array();
$bc['Documentales'] = $this->createUrl('index');
$bc['Documental'] = $this->createUrl('view', array('id' => $model->id));
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>

<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
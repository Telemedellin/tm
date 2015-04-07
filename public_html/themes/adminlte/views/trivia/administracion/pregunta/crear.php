<?php 
$this->pageTitle = 'Crear pregunta'; 
$bc = array();
$bc['Trivias'] = $this->createUrl('index');
$bc['Trivia'] = $this->createUrl('view', array('id' => $model->id));
$bc[] = 'Crear';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
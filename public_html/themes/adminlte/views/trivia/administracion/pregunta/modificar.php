<?php 
$this->pageTitle = 'Modificar pregunta ' . $model->pregunta; 
$bc = array();
$bc['Trivias'] = $this->createUrl('index');
$bc['Trivia'] = $this->createUrl('view', array('id' => $model->id));
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
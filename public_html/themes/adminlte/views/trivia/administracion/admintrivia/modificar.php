<?php 
$this->pageTitle = 'Modificar trivia ' . $model->fecha_inicio . ' - ' . $model->fecha_fin; 
$bc = array();
$bc['Trivias'] = $this->createUrl('index');
$bc['Trivia'] = $this->createUrl('view', array('id', $model->id) );
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
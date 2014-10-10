<?php 
$this->pageTitle = 'Crear pregunta'; 
$bc = array();
$bc['Trivias'] = bu('/trivia/administracion');
$bc['Trivia'] = bu('/trivia/administracion/view/'. $model->id);
$bc[] = 'Crear';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
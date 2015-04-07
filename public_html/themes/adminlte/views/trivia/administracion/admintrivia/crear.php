<?php 
$this->pageTitle = 'Crear trivia'; 
$bc = array();
$bc['Trivias'] = $this->createUrl('index');
$bc[] = 'Crear';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
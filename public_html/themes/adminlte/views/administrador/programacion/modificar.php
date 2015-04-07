<?php 
$this->pageTitle = 'Modificar programación "' . $model->micrositio->nombre. '"'; 
$bc = array();
$bc['Programación'] = $this->createUrl('index');
$bc['Programa'] = $this->createUrl('view', array('id' => $model->id));
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
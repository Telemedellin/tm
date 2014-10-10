<?php 
$this->pageTitle = 'Modificar programación "' . $model->micrositio->nombre. '"'; 
$bc = array();
$bc['Programación'] = bu('/administrador/programacion');
$bc['Programa'] = bu('/administrador/programacion/view/'.$model->id);
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
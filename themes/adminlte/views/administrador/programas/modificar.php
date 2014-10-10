<?php 
$this->pageTitle = 'Modificar programa "' . $model->nombre. '"'; 
$bc = array();
$bc['Programas'] = bu('/administrador/programas');
$bc['Programa'] = bu('/administrador/programas/view/'.$model->id);
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>

<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
<?php 
$this->pageTitle = 'Modificar documental "' . $model->nombre. '"'; 
$bc = array();
$bc['Documentales'] = bu('/administrador/documentales');
$bc['Documental'] = bu('/administrador/documentales/view/'.$model->id);
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>

<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
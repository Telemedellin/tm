<?php 
$this->pageTitle = 'Modificar banner "' . $model->nombre. '"'; 
$bc = array();
$bc['Banners'] = bu('/administrador/novedades/banners');
$bc['Banner'] = bu('/administrador/novedades/banners/view/'.$model->id);
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form_banner', array('model'=>$model)); ?>
</div>
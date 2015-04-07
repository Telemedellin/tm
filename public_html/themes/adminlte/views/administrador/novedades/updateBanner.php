<?php 
$this->pageTitle = 'Modificar banner "' . $model->nombre. '"'; 
$bc = array();
$bc['Banners'] = $this->createUrl('banners');
$bc['Banner'] = $this->createUrl('viewbanner', array('id' => $model->id));
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form_banner', array('model'=>$model)); ?>
</div>
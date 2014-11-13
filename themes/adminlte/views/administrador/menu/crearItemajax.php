<?php 
$this->pageTitle = 'Crear item de menú'; 
$bc = array();
$bc['Padre'] = Yii::app()->request->urlReferrer;
$bc[] = 'Crear';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form_item_ajax', array('model' => $model, 'menu' => $menu, 'paginas' => $paginas)); ?>
</div>
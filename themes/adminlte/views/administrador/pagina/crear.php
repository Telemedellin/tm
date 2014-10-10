<?php 
$this->pageTitle = 'Crear página'; 
$bc = array();
$bc['Padre'] = Yii::app()->request->urlReferrer;
$bc[] = 'Crear';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model, 'partial' => $partial, 'contenido' => $contenido)); ?>
</div>
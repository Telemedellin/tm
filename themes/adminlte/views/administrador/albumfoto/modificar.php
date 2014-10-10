<?php 
$this->pageTitle = 'Modificar álbum de fotos  "' . $model->nombre. '"'; 
$bc = array();
$bc['Padre'] = Yii::app()->request->urlReferrer;
$bc['Álbum de fotos'] = bu('/administrador/albumfoto/view/'.$model->id);
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
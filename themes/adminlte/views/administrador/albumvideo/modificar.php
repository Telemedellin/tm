<?php 
$this->pageTitle = 'Modificar álbum de video "' . $model->nombre. '"'; 
$bc = array();
$bc['Padre'] = Yii::app()->request->urlReferrer;
$bc['Álbum video'] = bu('/administrador/albumvideo/view/'.$model->id);
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
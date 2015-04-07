<?php $this->pageTitle = 'Modificar red social ' . $model->tipoRedSocial->nombre . ' ' . $model->usuario; ?>
<h1>Modificar red social <?php echo $model->tipoRedSocial->nombre . ' ' . $model->usuario ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
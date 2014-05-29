<?php $this->pageTitle = 'Modificar album de fotos ' . $model->nombre; ?>
<h1>Modificar album de fotos <?php echo $model->nombre; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
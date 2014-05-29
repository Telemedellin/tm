<?php $this->pageTitle = 'Modificar novedad ' . $model->nombre; ?>
<h1>Modificar novedad "<?php echo $model->nombre; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
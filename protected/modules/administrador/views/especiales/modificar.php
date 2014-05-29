<?php $this->pageTitle = 'Modificar especial ' . $model->nombre; ?>
<h1>Modificar Especial <?php echo $model->nombre; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
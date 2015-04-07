<?php $this->pageTitle = 'Moficiar video ' . $model->nombre; ?>
<h1>Modificar Video <?php echo $model->nombre; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
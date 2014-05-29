<?php $this->pageTitle = 'Modificar programación ' . $model->micrositio->nombre; ?>
<h1>Modificar programación <?php echo $model->micrositio->nombre; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
<?php $this->pageTitle = 'Modificar guiño ' . $model->nombre; ?>
<h1>Modificar Guiño <?php echo $model->nombre; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
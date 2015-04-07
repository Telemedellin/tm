<?php $this->pageTitle = 'Modificar album de videos ' . $model->nombre; ?>
<h1>Modificar album de videos <?php echo $model->nombre; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
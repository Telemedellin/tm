<?php $this->pageTitle = 'Modificar trivia ' . $model->fecha_inicio . ' - ' . $model->fecha_fin; ?>
<h1>Modificar Trivia <?php echo $model->fecha_inicio . ' - ' . $model->fecha_fin; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
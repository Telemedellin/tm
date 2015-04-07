<?php $this->pageTitle = 'Modificar banner ' . $model->nombre; ?>
<h1>Modificar Banner <?php echo $model->nombre; ?></h1>

<?php echo $this->renderPartial('_form_banner', array('model'=>$model)); ?>
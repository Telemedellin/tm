<?php $this->pageTitle = 'Modificar página ' . $model->nombre; ?>
<h1>Modificar Página <?php echo $model->nombre; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'partial' => $partial, 'contenido' => $contenido)); ?>
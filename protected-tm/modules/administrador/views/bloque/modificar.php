<?php $this->pageTitle = 'Modificar bloque ' . $model->titulo; ?>
<h1>Modificar Bloque "<?php echo $model->titulo; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
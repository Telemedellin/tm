<?php $this->pageTitle = 'Modificar item de menú ' . $model->label; ?>
<h1>Modificar Item de menú <?php echo $model->label; ?></h1>

<?php echo $this->renderPartial('_form_item', array('model'=>$model, 'menu' => $menu, 'paginas' => $paginas)); ?>
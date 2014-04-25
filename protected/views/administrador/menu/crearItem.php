<h1>Crear Item <?php echo $model->label; ?></h1>

<?php echo $this->renderPartial('_form_item', array('model'=>$model, 'menu' => $menu, 'paginas' => $paginas)); ?>
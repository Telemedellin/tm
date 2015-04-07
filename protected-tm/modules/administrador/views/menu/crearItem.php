<?php $this->pageTitle = 'Crear item de menú'; ?>
<h1>Crear Item de menú</h1>

<?php echo $this->renderPartial('_form_item', array('model'=>$model, 'menu' => $menu, 'paginas' => $paginas)); ?>
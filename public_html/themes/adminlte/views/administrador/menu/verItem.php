<?php $this->pageTitle = 'Item de menú ' . $model->label; ?>
<?php 
$this->pageTitle = 'Item de menú "' . $model->label.'"'; 
$bc = array();
$bc['menu'] = $this->createUrl('view', array('id' => $model->menu_id));
$bc[] = 'Menú';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
	<?php $this->renderPartial('//layouts/commons/_flashes'); ?>
	<div class="box box-primary">
        <div class="box-header">
        	<h3 class="box-title">Detalles</h3>
			<div class="box-tools pull-right">
				<?php if(Yii::app()->user->checkAccess('editar_menu_items')): ?>
					<?php echo l('<i class="fa fa-pencil"></i> Editar', $this->createUrl('updateitem', array('id' => $model->id)), array('class' => 'btn btn-primary'))?>
				<?php endif ?>
				<?php if(Yii::app()->user->checkAccess('eliminar_menu_items')): ?>
				<?php echo l('<small><i class="fa fa-trash-o"></i> Eliminar</small>', $this->createUrl('deleteitem', array('id' => $model->id)), array('onclick' => "if( !window.confirm('¿Seguro que desea borrar el item de menú \'".$model->label."\'?')) {return false;}", 'class' => 'btn btn-danger btn-xs'))?>
				<?php endif ?>
			</div>
        </div>
        <div class="box-body">
			<?php $this->widget('zii.widgets.CDetailView', array(
				'data' => $model,
				'attributes'=>array(
					'label', 
					array(
						'name' => 'menu.nombre', 
						'label' => 'Menú', 
					),
					'tipoLink.nombre', 
					array(
			            'name' => 'url_id', 
			            'type' => 'raw', 
			            'value' => l('<i class="fa fa-external-link"></i> ' .$model->urlx->slug, bu($model->urlx->slug), array("target" => "_blank")), 
			        ),
			        'orden', 
					'creado',
					'modificado',
					array(
						'name' => 'estado',
						'value' => ($model->estado==1)?'Sí':'No',
					),
				),
			)); ?>
		</div>
	</div>
</div>
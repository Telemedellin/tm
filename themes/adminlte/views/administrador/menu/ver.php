<?php 
$this->pageTitle = 'Menú "' . $model->nombre . '"'; 
$bc = array();
$bc['menu'] = bu('/administrador/menu');
$bc[] = 'Menú';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
	<?php $this->renderPartial('//layouts/commons/_flashes'); ?>
	<div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Detalles</h3>
            <div class="box-tools pull-right">
			  <?php if(Yii::app()->user->checkAccess('editar_menu')): ?>
			  <?php echo l('<i class="fa fa-pencil"></i> Editar', bu('administrador/menu/update/' . $model->id), array('class' => 'btn btn-primary'))?>
			  <?php endif ?>
			  <?php if(Yii::app()->user->checkAccess('eliminar_menu')): ?>
			  <?php echo l('<small><i class="fa fa-trash-o"></i> Eliminar</small>', bu('administrador/menu/delete/' . $model->id), array('onclick' => "if( !window.confirm('¿Seguro que desea borrar el Menú \'".$model->nombre."\'?')) {return false;}", 'class' => 'btn btn-danger btn-xs'))?>
			  <?php endif ?>
			</div>
        </div>
        <div class="box-body">
			<?php $this->widget('zii.widgets.CDetailView', array(
				'data' => $model,
				'attributes'=>array(
					'nombre',
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
<?php if(Yii::app()->user->checkAccess('ver_menu_items'))
{
	$tabs_content = array(
        'menuItems'=>array(
            'title'=>'Items',
            'view'=>'_menuItems', 
            'data'=> array('menuItems' => $menuItems, 'model' => $model)
        )
    );
}
?>
<div class="col-sm-12">
	<div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Contenido adicional</h3>
        </div>
    	<div class="box-body">
    		<?php if( isset($tabs_content) ) $this->widget('application.components.MyTabView', array('tabs' => $tabs_content));?>
    	</div>
    </div>
</div>
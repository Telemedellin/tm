<?php 
$this->pageTitle = 'Trivia del ' . $model->fecha_inicio . ' al ' . $model->fecha_fin; 
$bc = array();
$bc['Trivias'] = $this->createUrl('index');
$bc[] = 'Trivia';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
	<?php $this->renderPartial('//layouts/commons/_flashes'); ?>
	<div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Detalles</h3>
            <div class="box-tools pull-right">
			  <?php if(Yii::app()->user->checkAccess('editar_trivia')): ?>
			  <?php echo l('<i class="fa fa-pencil"></i> Editar', $this->createUrl('update', array('id' => $model->id) ), array('class' => 'btn btn-primary'))?>
			  <?php endif ?>
			  <?php if(Yii::app()->user->checkAccess('eliminar_trivia')): ?>
			  <?php echo l('<small><i class="fa fa-trash-o"></i> Eliminar</small>', $this->createUrl('delete', array('id' => $model->id) ), array('onclick' => "if( !window.confirm('¿Seguro que desea borrar la trivia \'".$model->id."\'?')) {return false;}", 'class' => 'btn btn-danger btn-xs'))?>
			  <?php endif ?>
			</div>
        </div>
        <div class="box-body">
			<?php $this->widget('zii.widgets.CDetailView', array(
				'data' => $model, 
				'attributes'=>array(
					'id',
					'fecha_inicio',
					'fecha_fin',
					'puntos',
					array(
						'name' => 'contenido.estado',
						'label' => 'Estado', 
						'value' => ($model->estado==1)?'Publicado':'Desactivado',
					),
				),
			)); ?>
		</div>
	</div>
</div>
<?php 
if( Yii::app()->user->checkAccess('ver_preguntas') )
{
	$tabs_content['preguntas'] = 
		array(
            'title'=>'Preguntas',
            'view'=>'/pregunta/_preguntas', 
            'data'=> array('preguntas' => $preguntas, 'model' => $model)
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
<?php
/* @var $this PaginaController */
/* @var $model Pagina */
/* @var $form CActiveForm */
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pagina-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'micrositio_id'); ?>
		<?php 
			/*$micrositios = Micrositio::model()->findAll();
			$datos = array();
			foreach($micrositios as $micrositio)
			{
				$datos[$micrositio->id] = $micrositio->nombre;
			}
			$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			    'name'=>'micrositio_id',
			    //'model'=> new Micrositio,
			    'source'=> $datos,
			    // additional javascript options for the autocomplete plugin
			    'options'=>array(
			        'minLength'=>'3',
			    ),
			    'htmlOptions'=>array(
			        'style'=>'height:20px;',
			    ),
			));*/
		?>
		<?php echo $form->dropDownList($model,'micrositio_id', CHtml::listData(Micrositio::model()->findAll(), 'id', 'nombre') ); ?>
		<?php echo $form->error($model,'micrositio_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'url_id'); ?>
		<?php echo $form->dropDownList($model,'url_id', CHtml::listData(Url::model()->findAll(), 'id', 'slug') ); ?>
		<?php echo $form->error($model,'url_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'estado'); ?>
		<?php echo $form->dropDownList($model,'estado', array('1' => 'Activo', '0' => 'Inactivo' ) ); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'destacado'); ?>
		<?php echo $form->dropDownList($model,'destacado', array('0' => 'No', '1' => 'Si' ) ); ?>
		<?php echo $form->error($model,'destacado'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'tipo_pagina_id'); ?>
		<?php echo $form->dropDownList($model,'tipo_pagina_id', CHtml::listData(TipoPagina::model()->findAll(), 'id', 'nombre') ); ?>
		<?php echo $form->error($model,'tipo_pagina_id'); ?>
	</div>

	<!--Aquí debo hacer que se cargue el formulario según el tipo de página elegido para llenar el contenido de una vez -->

	<div class="form-group buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
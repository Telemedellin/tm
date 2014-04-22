<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pagina-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data', 
        'role' => 'form',
        'class' => 'form-horizontal' 
    )
)); ?>
	<?php echo $form->errorSummary( array($model, $contenido) ); ?>
	<div class="form-group">
		<?php echo $form->label($model,'micrositio_id', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-6">
			<?php 
				$opciones = array('class' => 'form-control'); 
				if(!$model->isNewRecord) $opciones['disabled'] = true;
			?>
			<?php echo $form->dropDownList($model,'micrositio_id', CHtml::listData(Micrositio::model()->findAll(), 'id', 'nombre'), $opciones ); ?>
			<?php  ?>
		</div>
		<?php echo $form->error($model,'micrositio_id'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'nombre', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-6">
			<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>100, 'class' => 'form-control')); ?>
		</div>
		<?php echo $form->error($model,'nombre'); ?>
	</div>
	<div class="form-group">
        <?php echo $form->label($model,'meta_descripcion', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
            <?php echo $form->textArea($model,'meta_descripcion',array('rows'=> 3,'maxlength'=>200, 'class' => 'form-control', 'placeholder' => 'Esta descripción es solo para motores de búsqueda y no debe contener más de 160 carcteres.')); ?>
        </div>
        <?php echo $form->error($model,'meta_descripcion'); ?>
    </div>
	<div class="form-group">
		<?php echo $form->label($model,'estado', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-2">
			<?php echo $form->dropDownList($model,'estado', array('1' => 'Si', '0' => 'No' ), array('class' => 'form-control') ); ?>
		</div>
		<?php echo $form->error($model,'estado'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'destacado', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-2">
			<?php echo $form->dropDownList($model,'destacado', array('0' => 'No', '1' => 'Si' ), array('class' => 'form-control') ); ?>
		</div>
		<?php echo $form->error($model,'destacado'); ?>
	</div>
	<div id="contenido">
		<h3>Página <?php echo $model->tipoPagina->nombre ?></h3>
		<?php $this->renderPartial('_' . lcfirst($partial) . 'Form', array('contenido' => $contenido, 'form' => $form)); 
		?>
	</div>
	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
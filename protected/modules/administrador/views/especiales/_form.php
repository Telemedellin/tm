<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'url-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data', 
        'role' => 'form',
        'class' => 'form-horizontal' 
    )
)); ?>
	<?php echo $form->errorSummary($model); ?>
	<div class="form-group">
		<?php echo $form->label($model,'nombre', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
		  <?php echo $form->textField($model, 'nombre', array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
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
        <?php echo $this->imageField($form, $model, 'imagen', 'archivoImagen', '_especial'); ?>
	</div>
    <div class="form-group">
        <?php echo $this->imageField($form, $model, 'imagen_mobile', 'archivoImagenMobile', '_especial'); ?>
    </div>
	<div class="form-group">
        <?php echo $this->imageField($form, $model, 'miniatura', 'archivoMiniatura', '_especial'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'estado', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-2">
		  <?php echo $form->dropDownList($model, 'estado', array(2 => 'Publicado (Se ve en listados)', 1 => 'Archivado', 0 => 'No' ), array('class' => 'form-control')); ?>
        </div>
		<?php echo $form->error($model,'estado'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'destacado', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-2">
		  <?php echo $form->dropDownList($model, 'destacado', array(0 => 'No', 1 => 'Si' ), array('class' => 'form-control')); ?>
        </div>
		<?php echo $form->error($model,'destacado'); ?>
	</div>
	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary')); ?>
	</div>
	<input type="hidden" value="<?php echo Yii::app()->request->baseUrl ?>" id="PUBLIC_PATH"/>
<?php $this->endWidget(); ?>
</div><!-- form -->
<?php echo $this->renderPartial('../_file_upload_tmpl') ?>
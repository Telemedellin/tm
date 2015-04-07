<?php 
$formulario = new Formulario($contenido['contenido']);
echo $formulario->render();

/*
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'custom-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data', 
        'role' => 'form',
        'class' => 'form-horizontal'
    )
)); ?>
<div id="video" class="row">
    <div class="span6">
        <div class="control-group">
        	<?php echo $form->label($model,'nombre', array('class' => 'control-label')); ?>
        	<div class="controls">
        		<?php echo $form->textField($model, 'nombre', array('size'=>60,'maxlength'=>100, 'required' => true)); ?>
        	</div>
        	<?php echo $form->error($model,'nombre'); ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?> 
/**/ ?>
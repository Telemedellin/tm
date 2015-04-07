<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'url-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'role' => 'form',
        'class' => 'form-horizontal' 
    )
)); ?>
	<?php echo $form->errorSummary($model); ?>
	<div class="form-group">
        <?php echo $form->label($model, 'item_id', array('class' => 'col-sm-2 control-label'));?>
        <div class="col-sm-6">
            <?php echo $form->dropDownList($model, 'item_id', CHtml::listData(Carpeta::getList($pagina->id), 'id', 'carpeta'), array('empty' => $pagina->nombre, 'class' => 'form-control') ); ?>
        </div>
        <?php echo $form->error($model,'item_id'); ?>
    </div>
    <div class="form-group">
		<?php echo $form->label($model,'carpeta', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-6">
            <?php echo $form->textField($model, 'carpeta', array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
		</div>
        <?php echo $form->error($model,'carpeta'); ?>
	</div>
    <div class="form-group">
		<?php echo $form->label($model,'estado', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-2">
            <?php echo $form->dropDownList($model, 'estado', array(1 => 'Activa', 0 => 'Desactivada' ), array('class' => 'form-control')); ?>
		</div>
        <?php echo $form->error($model,'estado'); ?>
	</div>
	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
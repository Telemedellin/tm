<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'url-form',
	'enableAjaxValidation'=>false
)); ?>
	<?php echo $form->errorSummary($model); ?>
	<div class="form-group">
        <?php echo $form->label($model,'micrositio'); ?>
        <?php echo $form->dropDownList($model, 'micrositio', CHtml::listData(Micrositio::model()->findAll(), 'id', 'nombre') ); ?>
        <?php echo $form->error($model,'micrositio'); ?>
    </div>
    <div class="form-group">
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model, 'nombre'); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>
	<div class="form-group">
        <?php echo $form->label($model,'thumb'); ?>
        <?php echo $form->textField($model, 'thumb'); ?>
        <?php echo $form->error($model,'thumb'); ?>
    </div>
	<div class="form-group">
		<?php echo $form->label($model,'estado'); ?>
		<?php echo $form->dropDownList($model, 'estado', array(1 => 'Si', 0 => 'No' )); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>
    <div class="form-group">
        <?php echo $form->label($model,'destacado'); ?>
        <?php echo $form->dropDownList($model, 'destacado', array(1 => 'Si', 0 => 'No' )); ?>
        <?php echo $form->error($model,'destacado'); ?>
    </div>
	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->

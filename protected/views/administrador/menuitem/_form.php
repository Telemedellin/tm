<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'menuitem-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
        'role' => 'form',
        'class' => 'form-horizontal' 
    )
)); ?>
	<?php echo $form->errorSummary( $model ); ?>
	<div class="form-group">
		<?php echo $form->label($model,'menu_id', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-6">
			<?php 
				$opciones = array('class' => 'form-control'); 
				if(!$model->isNewRecord) $opciones['disabled'] = true;
			?>
			<?php echo $form->dropDownList($model,'menu_id', CHtml::listData(Menu::model()->findAll(), 'id', 'nombre'), $opciones ); ?>
			<?php  ?>
		</div>
		<?php echo $form->error($model,'menu_id'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'label', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-6">
			<?php echo $form->textField($model,'label',array('size'=>60,'maxlength'=>100, 'class' => 'form-control')); ?>
		</div>
		<?php echo $form->error($model,'label'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'estado', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-2">
			<?php echo $form->dropDownList($model,'estado', array('1' => 'Si', '0' => 'No' ), array('class' => 'form-control') ); ?>
		</div>
		<?php echo $form->error($model,'estado'); ?>
	</div>
	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
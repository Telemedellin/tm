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
        <?php echo $form->label($model,'micrositio_id', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
            <?php 
                $opciones = array('class' => 'form-control'); 
                if(!$model->isNewRecord) $opciones['disabled'] = true;
            ?>
            <?php echo $form->dropDownList($model, 'micrositio_id', CHtml::listData(Micrositio::model()->findAll(), 'id', 'nombre'), $opciones ); ?>
        </div>
        <?php echo $form->error($model,'micrositio_id'); ?>
    </div>
    <div class="form-group">
		<?php echo $form->label($model,'nombre', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-6">
            <?php echo $form->textField($model, 'nombre', array('class' => 'form-control')); ?>
		</div>
        <?php echo $form->error($model,'nombre'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'estado', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-2">
            <?php echo $form->dropDownList($model, 'estado', array(1 => 'Si', 0 => 'No' ), array('class' => 'form-control')); ?>
		</div>
        <?php echo $form->error($model,'estado'); ?>
	</div>
    <div class="form-group">
        <?php echo $form->label($model,'destacado', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-2">
            <?php echo $form->dropDownList($model, 'destacado', array(1 => 'Si', 0 => 'No' ), array('class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($model,'destacado'); ?>
    </div>
	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
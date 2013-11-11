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
        <?php echo $form->label($model,'micrositio_id', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
        	<?php echo $form->dropDownList($model, 'micrositio_id', CHtml::listData(Micrositio::model()->findAll(), 'id', 'nombre'), array('class' => 'form-control') ); ?>
        </div>
        <?php echo $form->error($model,'micrositio_id'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label($model,'tipo_red_social_id', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
        	<?php echo $form->dropDownList($model, 'tipo_red_social_id', CHtml::listData(TipoRedSocial::model()->findAll(), 'id', 'nombre'), array('class' => 'form-control') ); ?>
        </div>
        <?php echo $form->error($model,'tipo_red_social_id'); ?>
    </div>
    <div class="form-group">
		<?php echo $form->label($model,'usuario', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-4">
			<?php echo $form->textField($model, 'usuario', array('class' => 'form-control')); ?>
		</div>
		<?php echo $form->error($model,'usuario'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'estado', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-2">
			<?php echo $form->dropDownList($model, 'estado', array(1 => 'Si', 0 => 'No' ), array('class' => 'form-control')); ?>
		</div>
		<?php echo $form->error($model,'estado'); ?>
	</div>
	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary')); ?>
	</div>
	<input type="hidden" value="<?php echo Yii::app()->request->baseUrl ?>" id="PUBLIC_PATH"/>
<?php $this->endWidget(); ?>
</div><!-- form -->
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
        <?php echo $form->label($model,'pg_documental_id', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
        	<?php echo $form->dropDownList($model, 'pg_documental_id', CHtml::listData(PgDocumental::model()->findAll(), 'id', 'titulo'), array('class' => 'form-control') ); ?>
        </div>
        <?php echo $form->error($model,'pg_documental_id'); ?>
    </div>
    <div class="form-group">
		<?php echo $form->label($model,'campo', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-4">
			<?php echo $form->textField($model, 'campo', array('class' => 'form-control')); ?>
		</div>
		<?php echo $form->error($model,'campo'); ?>
	</div>
	<div class="form-group">
        <?php echo $form->label($model,'valor', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-4">
        	<?php echo $form->textField($model, 'valor', array('class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($model,'valor'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label($model,'orden', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-2">
        	<?php echo $form->numberField($model, 'orden', array('class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($model,'orden'); ?>
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
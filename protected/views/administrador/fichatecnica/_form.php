<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'url-form',
	'enableAjaxValidation'=>false
)); ?>
	<?php echo $form->errorSummary($model); ?>
	<div class="form-group">
        <?php echo $form->label($model,'pg_documental_id'); ?>
        <?php echo $form->dropDownList($model, 'pg_documental_id', CHtml::listData(PgDocumental::model()->findAll(), 'id', 'titulo') ); ?>
        <?php echo $form->error($model,'pg_documental_id'); ?>
    </div>
    <div class="form-group">
		<?php echo $form->label($model,'campo'); ?>
		<?php echo $form->textField($model, 'campo'); ?>
		<?php echo $form->error($model,'campo'); ?>
	</div>
	<div class="form-group">
        <?php echo $form->label($model,'valor'); ?>
        <?php echo $form->textField($model, 'valor'); ?>
        <?php echo $form->error($model,'valor'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label($model,'orden'); ?>
        <?php echo $form->numberField($model, 'orden'); ?>
        <?php echo $form->error($model,'orden'); ?>
    </div>
	<div class="form-group">
		<?php echo $form->label($model,'estado'); ?>
		<?php echo $form->dropDownList($model, 'estado', array(1 => 'Si', 0 => 'No' )); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>
	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary')); ?>
	</div>
	<input type="hidden" value="<?php echo Yii::app()->request->baseUrl ?>" id="PUBLIC_PATH"/>
<?php $this->endWidget(); ?>
</div><!-- form -->
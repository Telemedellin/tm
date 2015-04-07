<?php ?>
<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'bloque-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'role' => 'form',
        'class' => 'form-horizontal' 
    )
)); ?>
	<?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->label($model,'pg_bloques_id', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
            <?php echo $form->dropDownList($model, 'pg_bloques_id', CHtml::listData(PgBloques::model()->findAll('id = '.$model->pg_bloques_id), 'id', 'pagina.nombre'), array('class' => 'form-control') ); ?>
        </div>
        <?php echo $form->error($model,'pg_bloques_id'); ?>
    </div>
	<div class="form-group">
		<?php echo $form->label($model,'titulo', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-6">
            <?php echo $form->textField($model, 'titulo', array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
        </div>
		<?php echo $form->error($model,'titulo'); ?>
	</div>
    <div class="form-group">
        <?php echo $form->label($model,'columnas', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-2">
            <?php echo $form->numberField($model, 'columnas', array('min' => 1, 'max' => 12, 'step' => 1, 'class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($model,'columnas'); ?>
    </div>
	<div class="form-group">
		<?php echo $form->label($model,'contenido', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
        <?php $this->widget('ext.editMe.widgets.ExtEditMe', array(
            'model'=>$model,
            'attribute'=>'contenido',
            'toolbar' => array(
                            array(
                                'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat',
                            ),
                             array(
                                'TextColor', 'BGColor',
                            ),
                            array(
                                'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl',
                            ),
                            array(
                                'Link', 'Unlink', 'Anchor', 'Image',
                            ),
                            '/',
                            array(
                                'Source', '-', 'Undo', 'Redo', 
                            ),
                            array(
                                'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'
                            ),
                            array(
                                'Table', 'HorizontalRule', 'SpecialChar', 'PageBreak', 'Iframe'
                            ),
                            
                        ),
            'ckeConfig' => array(
                'extraAllowedContent' => 'script; a [*]',
            ),
            //'optionName'=>'optionValue',
        ));?>
        </div>
		<?php echo $form->error($model,'contenido'); ?>
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
            <?php echo $form->dropDownList($model, 'estado', array('1' => 'Si', '0' => 'No' ), array('class' => 'form-control')); ?>
        </div>
		<?php echo $form->error($model,'estado'); ?>
	</div>
	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary')); ?>
	</div>
    <?php echo CHtml::hiddenField('returnURL', Yii::app()->request->urlReferrer); ?>
<?php $this->endWidget(); ?>
</div><!-- form -->
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
        <?php echo $form->label($model,'album_video_id', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
            <?php echo $form->dropDownList($model, 'album_video_id', 
            CHtml::listData(
                AlbumVideo::model()->with('micrositio')->findAll(), 
                'id', 
                function($av) {
                    return $av->nombre . ' ('.$av->micrositio->nombre.')';
                }), array('class' => 'form-control') 
            ); ?>
        </div>
        <?php echo $form->error($model,'album_video_id'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label($model,'proveedor_video_id', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-2">
            <?php echo $form->dropDownList($model, 'proveedor_video_id', CHtml::listData(ProveedorVideo::model()->findAll(), 'id', 'nombre'), array('class' => 'form-control') ); ?>
        </div>
        <?php echo $form->error($model,'proveedor_video_id'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label($model,'url_video', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
            <?php echo $form->urlField($model, 'url_video', array('class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($model,'url_video'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label($model,'nombre', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
            <?php echo $form->textField($model, 'nombre', array('class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($model,'nombre'); ?>
    </div>
	<div class="form-group">
		<?php echo $form->label($model,'descripcion', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
            <?php //echo $form->textArea($model, 'descripcion'); ?>
        <?php $this->widget('ext.editMe.widgets.ExtEditMe', array(
            'model'=>$model,
            'attribute'=>'descripcion',
            'toolbar' => array(
                            array(
                                    
                            ),
                            array(
                                    'Undo', 'Redo', 'Source', '-', 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'
                            ),
                            '/',
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
                                    /*'Image', */'Table', 'HorizontalRule', 'SpecialChar', 'PageBreak', 'Iframe'
                            ),
                            array(
                                    'Link', 'Unlink', 'Anchor',
                            ),
                        ),
            //'optionName'=>'optionValue',
        ));?>
        </div>
		<?php echo $form->error($model,'descripcion'); ?>
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
            <?php echo $form->dropDownList($model, 'destacado', array(0 => 'No', 1 => 'Si' ), array('class' => 'form-control')); ?>
		</div>
        <?php echo $form->error($model,'destacado'); ?>
	</div>
	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
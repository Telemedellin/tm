<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'url-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
	<?php echo $form->errorSummary($model); ?>
    <div class="form-group">
        <?php echo $form->label($model,'album_video_id'); ?>
        <?php echo $form->dropDownList($model, 'album_video_id', 
            CHtml::listData(
                AlbumVideo::model()->with('micrositio')->findAll(), 
                'id', 
                function($av) {
                    return $av->nombre . ' ('.$av->micrositio->nombre.')';
                }) 
            ); ?>
        <?php echo $form->error($model,'album_video_id'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label($model,'proveedor_video_id'); ?>
        <?php echo $form->dropDownList($model, 'proveedor_video_id', CHtml::listData(ProveedorVideo::model()->findAll(), 'id', 'nombre') ); ?>
        <?php echo $form->error($model,'proveedor_video_id'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label($model,'url_video'); ?>
        <?php echo $form->urlField($model, 'url_video'); ?>
        <?php echo $form->error($model,'url_video'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label($model,'nombre'); ?>
        <?php echo $form->textField($model, 'nombre'); ?>
        <?php echo $form->error($model,'nombre'); ?>
    </div>
	<div class="form-group">
		<?php echo $form->label($model,'descripcion'); ?>
		<?php //echo $form->textArea($model, 'descripcion'); ?>
        <?php $this->widget('ext.editMe.widgets.ExtEditMe', array(
            'model'=>$model,
            'attribute'=>'descripcion',
            'toolbar' => array(
                            array(
                                    'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', 'Source',
                            ),
                            array(
                                    'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'
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
		<?php echo $form->error($model,'descripcion'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'estado'); ?>
		<?php echo $form->dropDownList($model, 'estado', array(1 => 'Si', 0 => 'No' )); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'destacado'); ?>
		<?php echo $form->dropDownList($model, 'destacado', array(0 => 'No', 1 => 'Si' )); ?>
		<?php echo $form->error($model,'destacado'); ?>
	</div>
	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
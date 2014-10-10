	<?php echo $form->hiddenField($contenido, 'id'); ?>
	<div class="form-group">
        <?php echo $form->label($contenido,'descripcion'); ?>
        <?php $this->widget('ext.editMe.widgets.ExtEditMe', array(
            'model'=>$contenido,
            'attribute'=>'descripcion',
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
                                /*'Image', */'Table', 'HorizontalRule', 'SpecialChar', 'PageBreak', 'Iframe'
                            ),
                            
                        ),
            //'optionName'=>'optionValue',
        ));?>
        <?php echo $form->error($contenido,'descripcion'); ?>
    </div>
	<div class="form-group">
        <?php echo $this->imageField($form, $contenido, 'imagen', 'archivoImagen', '_pagina'); ?>
	</div>
    <div class="form-group">
        <?php echo $this->imageField($form, $contenido, 'imagen_mobile', 'archivoImagenMobile', '_pagina'); ?>
    </div>
	<div class="form-group">
        <?php echo $this->imageField($form, $contenido, 'miniatura', 'archivoMiniatura', '_pagina'); ?>
	</div>
	<input type="hidden" value="<?php echo Yii::app()->request->baseUrl ?>" id="PUBLIC_PATH"/>
	<?php echo $this->renderPartial('//layouts/commons/_file_upload_tmpl') ?>
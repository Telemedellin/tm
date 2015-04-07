	<div class="form-group">
		<?php echo $form->hiddenField($contenido, 'id'); ?>
		<?php echo $form->label($contenido,'descripcion'); ?>
		<?php $this->widget('ext.editMe.widgets.ExtEditMe', array(
            'model'=>$contenido,
            'attribute'=>'descripcion',
            'toolbar' => array(
                            array(
                                'Format', 'Styles', 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat',
                            ),
                             array(
                                'TextColor', 'BGColor',
                            ),
                            array(
                                'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl',
                            ),
                            array(
                                'Link', 'Unlink', 'Anchor', 'Image'
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
            //'optionName'=>'optionValue',
        ));?>
		<?php echo $form->error($contenido,'descripcion'); ?>
	</div>
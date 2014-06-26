	<?php echo $form->hiddenField($contenido, 'id'); ?>
    <div class="form-group">
        <?php echo $form->label($contenido,'texto', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-10">
        <?php $this->widget('ext.editMe.widgets.ExtEditMe', array(
            'model'=>$contenido,
            'attribute'=>'texto',
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
        </div>
        <?php echo $form->error($contenido,'texto'); ?>
    </div>
    <div class="form-group">
        <?php echo $this->imageField($form, $contenido, 'miniatura', 'archivoMiniatura', '_pagina'); ?>
	</div>
    <div class="form-group">
        <?php echo $form->label($contenido,'comentarios', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-3">
            <?php echo $form->dropDownList($contenido, 'comentarios', array('0' => 'No', '1' => 'Sí' ), array('class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($contenido,'comentarios'); ?>
    </div>
	<input type="hidden" value="<?php echo Yii::app()->request->baseUrl ?>" id="PUBLIC_PATH"/>
	<?php echo $this->renderPartial('../_file_upload_tmpl') ?>
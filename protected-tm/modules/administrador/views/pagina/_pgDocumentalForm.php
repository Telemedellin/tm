	<div class="form-group">
        <?php echo $form->hiddenField($contenido, 'id'); ?>
        <?php echo $form->label($contenido,'titulo', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
            <?php echo $form->textField($contenido,'titulo',array('size'=>60,'maxlength'=>100, 'class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($contenido,'titulo'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label($contenido,'duracion', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-2">
            <?php echo $form->numberField($contenido,'duracion',array('size'=>60,'maxlength'=>100, 'class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($contenido,'duracion'); ?>
    </div>
    <div class="form-group">
        <?php echo $form->label($contenido,'anio', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-2">
            <?php echo $form->numberField($contenido,'anio',array('size'=>60,'maxlength'=>100, 'class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($contenido,'anio'); ?>
    </div>
    <div class="form-group">
		<?php echo $form->label($contenido,'sinopsis', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
            <?php //echo $form->textArea($contenido, 'sinopsis'); ?>
        <?php $this->widget('ext.editMe.widgets.ExtEditMe', array(
            'model'=>$contenido,
            'attribute'=>'sinopsis',
            'toolbar' => array(
                            array(
                                'Format', 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat',
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
		</div>
        <?php echo $form->error($contenido,'sinopsis'); ?>
	</div>
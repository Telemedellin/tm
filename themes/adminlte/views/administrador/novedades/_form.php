<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'url-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data', 
        'role' => 'form', 
    )
)); ?>
<?php $this->renderPartial('//layouts/commons/_form_error_summary', array('form' => $form, 'model' => $model)); ?>
<div class="row">
    <div class="col-sm-8">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Contenido</h3>
            </div>
            <div class="box-body">
               <div class="form-group">
            		<?php echo $form->label($model,'nombre'); ?>
            		<?php echo $form->textField($model, 'nombre', array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
                    <?php echo $form->error($model,'nombre'); ?>
            	</div>
            	<div class="form-group">
            		<?php echo $form->label($model,'entradilla'); ?>
            		<?php $this->widget('ext.editMe.widgets.ExtEditMe', array(
                        'model'=>$model,
                        'attribute'=>'entradilla',
                        'toolbar' => array(
                                        array(
                                            'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat',
                                        ),
                                         array(
                                            'TextColor', 'BGColor',
                                        ),
                                        array(
                                            'Link', 'Unlink', 'Anchor',  
                                        ),
                                        array(
                                            'Undo', 'Redo', 'Source',
                                        ),
                                        array(
                                            'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'
                                        )
                                    ),
                        //'optionName'=>'optionValue',
                    ));?>
            		<?php echo $form->error($model,'entradilla'); ?>
            	</div>
            	<div class="form-group">
            		<?php echo $form->label($model,'texto'); ?>
            		<?php $this->widget('ext.editMe.widgets.ExtEditMe', array(
                        'model'=>$model,
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
            		<?php echo $form->error($model,'texto'); ?>
            	</div>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Imágenes</h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $this->imageField($form, $model, 'imagen', 'archivoImagen'); ?>
            	</div>
                <div class="form-group">
                    <?php echo $this->imageField($form, $model, 'imagen_mobile', 'archivoImagenMobile'); ?>
                </div>
            	<div class="form-group">
                    <?php echo $this->imageField($form, $model, 'miniatura', 'archivoMiniatura', '', 59); ?>
            	</div>
                <input type="hidden" value="<?php echo Yii::app()->request->baseUrl ?>" id="PUBLIC_PATH"/>
            </div>
        </div>
    </div><!-- ./col-sm-8 -->
    <div class="col-sm-4">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Opciones</h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->label($model,'posicion'); ?>
                    <?php echo $form->dropDownList($model, 'posicion', array('1' => 'Arriba', '2' => 'Abajo' ), array('class' => 'form-control')); ?>
                    <?php echo $form->error($model,'posicion'); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->label($model,'estado'); ?>
                    <?php echo $form->dropDownList($model, 'estado', array('2' => 'Publicado (en el home)', '1' => 'Archivado', '0' => 'Desactivado' ), array('class' => 'form-control')); ?>
                    <?php echo $form->error($model,'estado'); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->label($model,'destacado'); ?>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-star"></i></span>
                        <?php echo $form->dropDownList($model, 'destacado', array('0' => 'No', '1' => 'Si' ), array('class' => 'form-control')); ?>
                    </div>
                    <?php echo $form->error($model,'destacado'); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->label($model,'comentarios'); ?>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-comments"></i></span>
                        <?php echo $form->dropDownList($model, 'comentarios', array('0' => 'No', '1' => 'Sí' ), array('class' => 'form-control')); ?>
                    </div>
                    <?php echo $form->error($model,'comentarios'); ?>
                </div>
                <div class="form-group">
                    <?php echo $form->label($model,'enlace'); ?>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-link"></i></span>
                        <?php echo $form->urlField($model, 'enlace', array('class' => 'form-control')); ?>
                    </div>
                    <?php echo $form->error($model,'enlace'); ?>
                </div>
                <div class="form-group buttons">
                    <?php echo CHtml::submitButton('Guardar todo', array('class' => 'btn btn-primary btn-block')); ?>
                </div>
            </div>
        </div>
    </div><!-- ./col-sm-4 -->
</div><!-- ./row -->
<?php $this->endWidget(); ?>
<?php echo $this->renderPartial('../_file_upload_tmpl') ?>
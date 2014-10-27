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
					<?php echo $form->textField($model, 'nombre', array('size'=>60,'maxlength'=>255, 'class' => 'form-control', 'required' => true)); ?>
			        <?php echo $form->error($model,'nombre'); ?>
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
			                                'Table', 'HorizontalRule', 'SpecialChar', 'PageBreak', 'Iframe'
			                            ),
			                            
			                        ),
			            //'optionName'=>'optionValue',
			        ));?>
					<?php echo $form->error($model,'texto'); ?>
				</div>
			    <div class="form-group">
			        <?php echo $form->label($model,'meta_descripcion'); ?>
			        <div style="overflow:hidden;">
			        <?php echo $form->textArea($model,'meta_descripcion',array('rows'=> 3,'maxlength'=>200, 'class' => 'form-control texto-limitado', 'data-limite' => '180', 'placeholder' => 'Esta descripción es solo para motores de búsqueda y no debe contener más de 160 carcteres.')); ?>
			       	</div>
			        <?php echo $form->error($model,'meta_descripcion'); ?>
			    </div>
			</div>
        </div>
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Imágenes</h3>
            </div>
            <div class="box-body">
				<div class="form-group">
			        <?php echo $this->imageField($form, $model, 'imagen', 'archivoImagen', '_concurso'); ?>
				</div>
			    <div class="form-group">
			        <?php echo $this->imageField($form, $model, 'imagen_mobile', 'archivoImagenMobile', '_concurso'); ?>
			    </div>
				<div class="form-group">
			        <?php echo $this->imageField($form, $model, 'miniatura', 'archivoMiniatura', '_concurso'); ?>
				</div>
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
			        <?php echo $form->label($model,'formulario'); ?>
			        <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-list-alt"></i></span>
			            <?php echo $form->textField($model, 'formulario', array('class' => 'form-control', 'placeholder' => '32834466613962')); ?>
			        </div>
			         <small class="help-block">Por ejemplo: http://www.jotform.com/?formID=<strong>32834466613962</strong></small>
			        <?php echo $form->error($model,'formulario'); ?>
			    </div>
				<div class="form-group">
					<?php echo $form->label($model,'estado'); ?>
					<?php echo $form->dropDownList($model, 'estado', array(2 => 'Publicado (Se ve en listados)', 1 => 'Archivado', 0 => 'No' ), array('class' => 'form-control', 'required' => true)); ?>
			        <?php echo $form->error($model,'estado'); ?>
				</div>
				<div class="form-group">
					<?php echo $form->label($model,'destacado'); ?>
					<div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-star"></i></span>
			            <?php echo $form->dropDownList($model, 'destacado', array('0' => 'No', '1' => 'Sí' ), array('class' => 'form-control', 'required' => true)); ?>
			        </div>
					<?php echo $form->error($model,'destacado'); ?>
				</div>
				<div class="form-group buttons">
					<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary btn-block')); ?>
				</div>
				<input type="hidden" value="<?php echo Yii::app()->request->baseUrl ?>" id="PUBLIC_PATH"/>
			</div>
        </div>
    </div><!-- ./col-sm-4 -->
</div><!-- ./row -->
<?php $this->endWidget(); ?>
<?php echo $this->renderPartial('//layouts/commons/_file_upload_tmpl') ?>
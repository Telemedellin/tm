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
					<?php echo $form->label($model,'sinopsis'); ?>
			        <?php $this->widget('ext.editMe.widgets.ExtEditMe', array(
			            'model'=>$model,
			            'attribute'=>'sinopsis',
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
			        <?php echo $form->error($model,'sinopsis'); ?>
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
			        <?php echo $this->imageField($form, $model, 'imagen', 'archivoImagen', '_documental'); ?>
				</div>
			    <div class="form-group">
			        <?php echo $this->imageField($form, $model, 'imagen_mobile', 'archivoImagenMobile', '_documental'); ?>
			    </div>
				<div class="form-group">
			        <?php echo $this->imageField($form, $model, 'miniatura', 'archivoMiniatura', '_documental'); ?>
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
			        <?php echo $form->label($model,'duracion'); ?>
			        <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
			        	<?php echo $form->numberField($model, 'duracion', array('class' => 'form-control')); ?>
			        </div>
			        <small class="help-block">Minutos, por ejemplo: 90</small>
			        <?php echo $form->error($model,'duracion'); ?>
			    </div>
			    <div class="form-group">
			        <?php echo $form->label($model,'anio'); ?>
			        <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			        	<?php echo $form->numberField($model, 'anio', array('class' => 'form-control')); ?>
			        </div>
			        <?php echo $form->error($model,'anio'); ?>
			    </div>
				<div class="form-group">
					<?php echo $form->label($model,'estado'); ?>
					<div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-eye"></i></span>
			        	<?php echo $form->dropDownList($model, 'estado', array(2 => 'Publicado (Se ve en listados)', 1 => 'Archivado', 0 => 'No' ), array('class' => 'form-control')); ?>
			        </div>
					<?php echo $form->error($model,'estado'); ?>
				</div>
				<div class="form-group">
					<?php echo $form->label($model,'destacado'); ?>
					<div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-star"></i></span>
			        	<?php echo $form->dropDownList($model, 'destacado', array(0 => 'No', 1 => 'Si' ), array('class' => 'form-control')); ?>
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
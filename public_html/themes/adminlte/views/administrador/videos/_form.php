<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'url-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array( 
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
			        <?php echo $form->label($model,'album_video_id'); ?>
			        <?php echo $form->dropDownList($model, 'album_video_id', 
		            CHtml::listData(
		                AlbumVideo::model()->with('micrositio')->findAll(), 
		                'id', 
		                function($av) {
		                    return $av->nombre . ' ('.$av->micrositio->nombre.')';
		                }), array('class' => 'form-control') 
		            ); ?>
			        <?php echo $form->error($model,'album_video_id'); ?>
			    </div>
			    <div class="form-group">
			        <?php echo $form->label($model,'proveedor_video_id'); ?>
			        <?php echo $form->dropDownList($model, 'proveedor_video_id', CHtml::listData(ProveedorVideo::model()->findAll(), 'id', 'nombre'), array('class' => 'form-control') ); ?>
			        <?php echo $form->error($model,'proveedor_video_id'); ?>
			    </div>
			    <div class="form-group">
			        <?php echo $form->label($model,'url_video'); ?>
			        <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-link"></i></span>
			            <?php echo $form->urlField($model, 'url_video', array('class' => 'form-control')); ?>
			        </div>
			        <?php echo $form->error($model,'url_video'); ?>
			    </div>
			    <div class="form-group">
			        <?php echo $form->label($model,'nombre'); ?>
			        <?php echo $form->textField($model, 'nombre', array('class' => 'form-control')); ?>
			        <?php echo $form->error($model,'nombre'); ?>
			    </div>
				<div class="form-group">
					<?php echo $form->label($model,'descripcion'); ?>
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
					<?php echo $form->error($model,'descripcion'); ?>
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
					<?php echo $form->label($model,'estado'); ?>
					<div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-eye"></i></span>
			            <?php echo $form->dropDownList($model, 'estado', array(1 => 'Sí', 0 => 'No' ), array('class' => 'form-control')); ?>
					</div>
			        <?php echo $form->error($model,'estado'); ?>
				</div>
				<div class="form-group">
					<?php echo $form->label($model,'destacado'); ?>
					<div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-star"></i></span>
			            <?php echo $form->dropDownList($model, 'destacado', array(0 => 'No', 1 => 'Sí' ), array('class' => 'form-control')); ?>
					</div>
			        <?php echo $form->error($model,'destacado'); ?>
				</div>
				<div class="form-group buttons">
					<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary btn-block')); ?>
				</div>
			</div>
        </div>
    </div><!-- ./col-sm-4 -->
</div><!-- ./row -->
<?php $this->endWidget(); ?>
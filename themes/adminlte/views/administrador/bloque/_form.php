<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'bloque-form',
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
					<?php echo $form->label($model,'titulo'); ?>
					<?php echo $form->textField($model, 'titulo', array('size'=>60,'maxlength'=>255, 'class' => 'form-control', 'required' => true)); ?>
			        <?php echo $form->error($model,'titulo'); ?>
				</div>
				<div class="form-group">
					<?php echo $form->label($model,'contenido'); ?>
					<?php $this->widget('ext.editMe.widgets.ExtEditMe', array(
			            'model'=>$model,
			            'attribute'=>'contenido',
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
			            'ckeConfig' => array(
			                'extraAllowedContent' => 'script; a [*]',
			            ),
			            //'optionName'=>'optionValue',
			        ));?>
			        <?php echo $form->error($model,'contenido'); ?>
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
			        <?php echo $form->label($model,'pg_bloques_id'); ?>
			        <?php echo $form->dropDownList($model, 'pg_bloques_id', CHtml::listData(PgBloques::model()->findAll('id = '.$model->pg_bloques_id), 'id', 'pagina.nombre'), array('class' => 'form-control', 'required' => true) ); ?>
			        <?php echo $form->error($model,'pg_bloques_id'); ?>
			    </div>
			    <div class="form-group">
			        <?php echo $form->label($model,'columnas'); ?>
			        <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-columns"></i></span>
			            <?php echo $form->numberField($model, 'columnas', array('min' => 1, 'max' => 12, 'step' => 1, 'class' => 'form-control', 'required' => true)); ?>
			        </div>
			        <?php echo $form->error($model,'columnas'); ?>
			    </div>
			    <div class="form-group">
			        <?php echo $form->label($model,'orden'); ?>
			        <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-sort-amount-asc"></i></span>
			            <?php echo $form->numberField($model, 'orden', array('class' => 'form-control', 'required' => true)); ?>
			        </div>
			        <?php echo $form->error($model,'orden'); ?>
			    </div>
			    <div class="form-group">
					<?php echo $form->label($model,'estado'); ?>
					<?php echo $form->dropDownList($model, 'estado', array('1' => 'Sí', '0' => 'No' ), array('class' => 'form-control', 'required' => true)); ?>
					<?php echo $form->error($model,'estado'); ?>
				</div>
				<div class="form-group buttons">
					<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary btn-block')); ?>
				</div>
			    <?php echo CHtml::hiddenField('returnURL', Yii::app()->request->urlReferrer); ?>
			</div>
        </div>
    </div><!-- ./col-sm-4 -->
</div><!-- ./row -->
<?php $this->endWidget(); ?>
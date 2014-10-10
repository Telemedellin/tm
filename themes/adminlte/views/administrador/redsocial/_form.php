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
			        <?php echo $form->label($model,'micrositio_id'); ?>
			        <?php echo $form->dropDownList($model, 'micrositio_id', CHtml::listData(Micrositio::model()->findAll(), 'id', 'nombre'), array('class' => 'form-control') ); ?>
			        <?php echo $form->error($model,'micrositio_id'); ?>
			    </div>
			    <div class="form-group">
			        <?php echo $form->label($model,'tipo_red_social_id'); ?>
			        <?php echo $form->dropDownList($model, 'tipo_red_social_id', CHtml::listData(TipoRedSocial::model()->findAll(), 'id', 'nombre'), array('class' => 'form-control') ); ?>
			        <?php echo $form->error($model,'tipo_red_social_id'); ?>
			    </div>
			    <div class="form-group">
					<?php echo $form->label($model,'usuario'); ?>
					<div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
						<?php echo $form->textField($model, 'usuario', array('class' => 'form-control')); ?>
					</div>
					<?php echo $form->error($model,'usuario'); ?>
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
						<?php echo $form->dropDownList($model, 'estado', array(1 => 'Si', 0 => 'No' ), array('class' => 'form-control')); ?>
					</div>
					<?php echo $form->error($model,'estado'); ?>
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
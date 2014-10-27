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
			        <?php echo $form->label($model,'pg_documental_id'); ?>
			        <?php echo $form->dropDownList($model, 'pg_documental_id', CHtml::listData(PgDocumental::model()->findAll(), 'id', 'titulo'), array('class' => 'form-control', 'required' => true) ); ?>
			        <?php echo $form->error($model,'pg_documental_id'); ?>
			    </div>
			    <div class="form-group">
					<?php echo $form->label($model,'campo'); ?>
					<?php echo $form->textField($model, 'campo', array('class' => 'form-control', 'required' => true)); ?>
					<?php echo $form->error($model,'campo'); ?>
				</div>
				<div class="form-group">
			        <?php echo $form->label($model,'valor'); ?>
			        <?php echo $form->textField($model, 'valor', array('class' => 'form-control', 'required' => true)); ?>
			        <?php echo $form->error($model,'valor'); ?>
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
			        <?php echo $form->label($model,'orden'); ?>
			        <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-sort-amount-asc"></i></span>
			        	<?php echo $form->numberField($model, 'orden', array('class' => 'form-control', 'required' => true)); ?>
			        </div>
			        <?php echo $form->error($model,'orden'); ?>
			    </div>
				<div class="form-group">
					<?php echo $form->label($model,'estado'); ?>
					<div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-eye"></i></span>
						<?php echo $form->dropDownList($model, 'estado', array(1 => 'Sí', 0 => 'No' ), array('class' => 'form-control', 'required' => true)); ?>
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
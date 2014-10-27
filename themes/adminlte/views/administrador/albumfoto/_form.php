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
                <h3 class="box-title">Configuración</h3>
            </div>
            <div class="box-body">
                <div class="form-group">
			        <?php echo $form->label($model,'micrositio_id'); ?>
			        <?php 
		                $opciones = array('class' => 'form-control'); 
		                if(!$model->isNewRecord) $opciones['disabled'] = true;
		            		echo $form->dropDownList($model, 'micrositio_id', CHtml::listData(Micrositio::model()->findAll(), 'id', 'nombre'), $opciones ); ?>
			        <?php echo $form->error($model,'micrositio_id'); ?>
			    </div>
			    <div class="form-group">
					<?php echo $form->label($model,'nombre'); ?>
					<?php echo $form->textField($model, 'nombre', array('class' => 'form-control', 'required' => true)); ?>
					<?php echo $form->error($model,'nombre'); ?>
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
						<?php echo $form->dropDownList($model, 'estado', array(1 => 'Publicado', 0 => 'Despublicado' ), array('class' => 'form-control', 'required' => true)); ?>
					</div>
			        <?php echo $form->error($model,'estado'); ?>
				</div>
			    <div class="form-group">
			        <?php echo $form->label($model,'destacado'); ?>
			        <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-star"></i></span>
			            <?php echo $form->dropDownList($model, 'destacado', array(1 => 'Si', 0 => 'No' ), array('class' => 'form-control', 'required' => true)); ?>
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
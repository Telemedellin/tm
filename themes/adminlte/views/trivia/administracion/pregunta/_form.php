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
    <div class="col-sm-9">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Pregunta</h3>
            </div>
            <div class="box-body">
            	<div class="form-group">
            		 <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-quote-left"></i></span>
						<?php echo $form->textField($model, 'pregunta', array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
						<span class="input-group-addon"><i class="fa fa-quote-right"></i></span>
					</div>
			        <?php echo $form->error($model,'pregunta'); ?>
				</div>
			</div>
        </div>
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Respuestas</h3>
            </div>
            <div class="box-body">
			    <?php foreach($model->respuestas_f as $r): ?>
			        <?php $this->renderPartial('_respuesta', array('model' => $r)); ?>
			    <?php endforeach ?>
                <button class="btn btn-success btn-block"><i class="fa fa-plus"></i> Agregar respuesta</button>
			</div>
        </div>
    </div><!-- ./col-sm-9 -->
    <div class="col-sm-3">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Opciones</h3>
            </div>
            <div class="box-body">
            	<div class="form-group">
					<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary btn-block')); ?>
				</div>
			</div>
		</div>
    </div><!-- ./col-sm-3 -->
</div><!-- ./row -->
<?php $this->endWidget(); ?>
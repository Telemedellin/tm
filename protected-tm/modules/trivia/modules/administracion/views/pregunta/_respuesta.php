<?php CHtml::beginForm();?>
	<div class="form-group">
	    <?php echo CHtml::label('Respuesta', 'respuesta', array('class' => 'col-sm-2 control-label')); ?>
	    <div class="col-sm-6">
	        <?php echo CHtml::textField('Respuesta['.$model->id.'][respuesta]', $model->respuesta, array('size'=>60,'maxlength'=>255, 'class' => 'form-control')); ?>
	    </div>
	    <div class="col-sm-2">
	         <?php echo CHtml::dropDownList('Respuesta['.$model->id.'][es_correcta]', $model->es_correcta, array(1 => 'Correcta', 0 => 'Equivocada' ), array('class' => 'form-control')); ?>
	        
	    </div>
	    <?php echo CHtml::error($model,'respuesta'); ?>
	</div>
<?php CHtml::endForm(); ?>
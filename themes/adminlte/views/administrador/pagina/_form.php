<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pagina-form',
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
					<?php echo $form->label($model,'micrositio_id'); ?>
					<?php 
						$opciones = array('class' => 'form-control'); 
						if(!$model->isNewRecord) $opciones['disabled'] = true;
					?>
					<?php echo $form->dropDownList($model,'micrositio_id', CHtml::listData(Micrositio::model()->findAll(), 'id', 'nombre'), $opciones ); ?>
					<?php echo $form->error($model,'micrositio_id'); ?>
				</div>
				<div class="form-group">
					<?php echo $form->label($model,'nombre'); ?>
					<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>100, 'class' => 'form-control')); ?>
					<?php echo $form->error($model,'nombre'); ?>
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
                <h3 class="box-title">Página <?php echo $partial ?></h3>
            </div>
            <div class="box-body">
            	<?php if (is_readable( $this->getViewPath().'/_' . lcfirst($partial) . 'Form' . '.php' )): ?>
				<div id="contenido">
					<?php $this->renderPartial('_' . lcfirst($partial) . 'Form', array('contenido' => $contenido, 'form' => $form)); 
					?>
				</div>
				<?php endif; ?>
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
						<?php echo $form->dropDownList($model,'estado', array('2' => 'Sí', '1' => 'Archivado', '0' => 'No' ), array('class' => 'form-control') ); ?>
					</div>
					<?php echo $form->error($model,'estado'); ?>
				</div>
				<div class="form-group">
					<?php echo $form->label($model,'destacado'); ?>
					<div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-star"></i></span>
						<?php echo $form->dropDownList($model,'destacado', array('0' => 'No', '1' => 'Sí' ), array('class' => 'form-control') ); ?>
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
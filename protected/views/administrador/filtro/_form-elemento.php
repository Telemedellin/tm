<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'url-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array( 
        'role' => 'form',
        'class' => 'form-horizontal' 
    )
)); ?>
	<?php echo $form->errorSummary($model); ?>
	<div class="form-group">
        <?php echo $form->label($model,'pg_filtro_id', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
        	<?php echo $form->dropDownList($model, 'pg_filtro_id', CHtml::listData(PgFiltro::model()->findAll(), 'id', 'pagina.nombre'), array('class' => 'form-control') ); ?>
        </div>
        <?php echo $form->error($model,'pg_filtro_id'); ?>
    </div>
	<div class="form-group">
	    <?php echo $form->label($model,'padre', array('class' => 'col-sm-2 control-label')); ?>
	    <div class="col-sm-6">
	        <?php 
	        	echo $form->dropDownList(
	        			$model, 
	        			'padre', 
	        			CHtml::listData(
	        				FiltroItem::model()->findAllByAttributes(
	        					array('pg_filtro_id' => $model->pg_filtro_id)
    						), 
    						'id', 
    						'elemento'
						), 
						array(
							'class' => 'form-control chosen', 
							'empty' => 'Sin padre'
						) 
					); 
			?>
	    </div>
	    <?php echo $form->error($model,'padre'); ?>
	</div>
    <div class="form-group">
		<?php echo $form->label($model,'elemento', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-4">
			<?php echo $form->textField($model, 'elemento', array('class' => 'form-control')); ?>
		</div>
		<?php echo $form->error($model,'elemento'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'estado', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-2">
			<?php echo $form->dropDownList($model, 'estado', array(1 => 'Si', 0 => 'No' ), array('class' => 'form-control')); ?>
		</div>
		<?php echo $form->error($model,'estado'); ?>
	</div>
	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
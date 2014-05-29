<?php
Yii::app()->clientScript->registerScript('menu_item', 
    "var mitl = $('#MenuItem_tipo_link_id'), 
    	miu = $('#MenuItem_url'),
    	miui = $('#MenuItem_url_id');
    miu.parent().parent().hide();
    function verificar(el)
    {
    	if(el.val() == 1)
		{
			miu.parent().parent().hide();
			miui.parent().parent().show();
		}else
		{
			miu.parent().parent().show();
			miui.parent().parent().hide();
		}
		miu.val('');
		miui.val('');
    }
    mitl.change(function(event){
    	verificar($(this));
    });
	verificar(mitl);", 
    CClientScript::POS_READY);
?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'menuitem-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
        'role' => 'form',
        'class' => 'form-horizontal' 
    )
)); ?>
	<?php echo $form->errorSummary( $model ); ?>
	<div class="form-group">
		<?php echo $form->label($model,'menu_id', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-6">
			<?php 
				$opciones = array('class' => 'form-control'); 
				if(!$model->isNewRecord) $opciones['disabled'] = true;
			?>
			<?php echo $form->dropDownList($model,'menu_id', CHtml::listData(Menu::model()->findAll('id = '.$model->menu_id), 'id', 'nombre'), $opciones ); ?>
			<?php  ?>
		</div>
		<?php echo $form->error($model,'menu_id'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'label', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-6">
			<?php echo $form->textField($model,'label',array('size'=>60,'maxlength'=>100, 'class' => 'form-control')); ?>
		</div>
		<?php echo $form->error($model,'label'); ?>
	</div>
	<?php if($model->isNewRecord): ?>
	<div class="form-group">
		<?php echo $form->label($model,'tipo_link_id', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-2">
			<?php echo $form->dropDownList($model,'tipo_link_id', CHtml::listData(TipoLink::model()->findAll(), 'id', 'nombre'), array('class' => 'form-control') ); ?>
		</div>
		<?php echo $form->error($model,'tipo_link_id'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'url_id', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-6">
			<?php echo $form->dropDownList($model,'url_id', $paginas, array('class' => 'form-control', 'empty' => '') ); ?>
		</div>
		<?php echo $form->error($model,'url_id'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'url', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-6">
			<?php echo $form->urlField($model,'url',array('size'=>60,'maxlength'=>100, 'class' => 'form-control')); ?>
		</div>
		<?php echo $form->error($model,'url'); ?>
	</div>
	<?php endif; ?>
	<div class="form-group">
		<?php echo $form->label($model,'orden', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-2">
			<?php echo $form->numberField($model,'orden',array('size'=>60,'maxlength'=>100, 'class' => 'form-control')); ?>
		</div>
		<?php echo $form->error($model,'orden'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($model,'estado', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-2">
			<?php echo $form->dropDownList($model,'estado', array('1' => 'Si', '0' => 'No' ), array('class' => 'form-control') ); ?>
		</div>
		<?php echo $form->error($model,'estado'); ?>
	</div>
	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->
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
			miu.removeAttr('required');
			miui.parent().parent().show();
			miui.attr('required', true);
		}else
		{
			miu.parent().parent().show();
			miu.attr('required', true);
			miui.parent().parent().hide();
			miui.removeAttr('required');
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
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'menuitem-form',
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
					<?php echo $form->label($model,'menu_id'); ?>
					<?php 
						$opciones = array('class' => 'form-control'); 
						if(!$model->isNewRecord) $opciones['disabled'] = true;
					?>
					<?php echo $form->dropDownList($model,'menu_id', CHtml::listData(Menu::model()->findAll('id = '.$model->menu_id), 'id', 'nombre'), $opciones ); ?>
					<?php echo $form->error($model,'menu_id'); ?>
				</div>
				<div class="form-group">
					<?php echo $form->label($model,'label'); ?>
					<?php echo $form->textField($model,'label',array('size'=>60,'maxlength'=>100, 'class' => 'form-control')); ?>
					<?php echo $form->error($model,'label'); ?>
				</div>
				<?php if($model->isNewRecord): ?>
				<div class="form-group">
					<?php echo $form->label($model,'tipo_link_id'); ?>
					<?php echo $form->dropDownList($model,'tipo_link_id', CHtml::listData(TipoLink::model()->findAll(), 'id', 'nombre'), array('class' => 'form-control') ); ?>
					<?php echo $form->error($model,'tipo_link_id'); ?>
				</div>
				<div class="form-group">
					<?php echo $form->label($model,'url_id'); ?>
					<div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-link"></i></span>
						<?php echo $form->dropDownList($model,'url_id', $paginas, array('class' => 'form-control', 'empty' => '') ); ?>
					</div>
					<?php echo $form->error($model,'url_id'); ?>
				</div>
				<div class="form-group">
					<?php echo $form->label($model,'url'); ?>
					<div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-external-link"></i></span>
						<?php echo $form->urlField($model,'url',array('size'=>60,'maxlength'=>100, 'class' => 'form-control')); ?>
					</div>
					<?php echo $form->error($model,'url'); ?>
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
					<?php echo $form->label($model,'orden'); ?>
					<div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-sort-amount-asc"></i></span>
						<?php echo $form->numberField($model,'orden',array('size'=>60,'maxlength'=>100, 'class' => 'form-control')); ?>
					</div>
					<?php echo $form->error($model,'orden'); ?>
				</div>
				<div class="form-group">
					<?php echo $form->label($model,'estado'); ?>
					<div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-eye"></i></span>
						<?php echo $form->dropDownList($model,'estado', array('1' => 'Si', '0' => 'No' ), array('class' => 'form-control') ); ?>
					</div>
					<?php echo $form->error($model,'estado'); ?>
				</div>
				<div class="form-group buttons">
					<?php echo CHtml::submitButton('Guardar', array('class' => 'btn btn-primary btn-block')); ?>
				</div>
			</div>
		</div>
    </div><!-- ./col-sm-4 -->
</div><!-- ./row -->
<?php $this->endWidget(); ?>
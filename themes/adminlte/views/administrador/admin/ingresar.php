<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle= 'Ingresar - ' . Yii::app()->name;
?>
<div class="form login col-md-4 col-lg-offset-4">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Iniciar sesión</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
        <?php if(Yii::app()->user->hasFlash('loginflash')): ?>
        <div class="box-body">
			<div class="alert alert-warning alert-dismissable">
				<i class="fa fa-warning"></i>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<?php echo Yii::app()->user->getFlash('loginflash'); ?>
			</div>
		</div><!-- /.box-body -->
		<?php else: ?>
        <?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'login-form',
			//'enableAjaxValidation'=>true,
			'enableClientValidation'=>false,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
			'htmlOptions' => array(
					'role' => 'form', 
				)
		)); ?>
            <div class="box-body">
                <div class="form-group">
                    <?php echo $form->label($model,'username'); ?>
                    <div class="input-group">
						<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    	<?php echo $form->emailField($model,'username', array('class' => 'form-control')); ?>
                    </div>
                </div>
                <div class="form-group">
					<?php echo $form->label($model,'password'); ?>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock"></i></span>
						<?php echo $form->passwordField($model,'password', array('class' => 'form-control')); ?>
					</div>
				</div>
                <div class="checkbox rememberMe">
                	<label>
						<?php echo $form->checkBox($model,'rememberMe'); ?>
						Recordarme en este equipo
					</label>
				</div>
            </div><!-- /.box-body -->

            <div class="box-footer">
            	
				<?php /*Yii::app()->user->ui->tbutton(CrugeTranslator::t('logon', "Login", array('class' => 'btn btn-primary')));/**/ ?>
				<div class="form-group">
					<p><?php echo CHtml::submitButton('Iniciar sesión', array('class' =>'btn btn-primary btn-block')); ?></p>
					<p><small><?php echo Yii::app()->user->ui->passwordRecoveryLink; ?></small></p>
				</div>
            </div>
        <?php $this->endWidget(); ?>
    	<?php endif; ?>
    </div><!-- /.box -->
</div>
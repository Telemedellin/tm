<?php $this->pageTitle= 'Recuperar clave - ' . Yii::app()->name; ?>

<div class="form login col-md-4 col-lg-offset-4">
	<div class="box box-primary">
        <div class="box-header">
        	<h3 class="box-title">Recuperar clave</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
	        <?php
			if(Yii::app()->user->hasFlash('pwdrecflash')):
			    echo '<div class="alert alert-' . $key . ' alert-dismissable"><i class="fa fa-' . $key . '"></i>
			    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' . Yii::app()->user->getFlash('pwdrecflash') . "</div>\n";
			?>
			<?php else: ?>
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'pwdrcv-form',
					'enableClientValidation'=>false,
					'clientOptions'=>array(
						'validateOnSubmit'=>true,
					),
				)); ?>

					<div class="form-group">
						<?php echo $form->label($model,'username'); ?>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
							<?php echo $form->textField($model,'username', array('class' => 'form-control')); ?>
						</div>
						<?php echo $form->error($model,'username'); ?>
					</div>
					
					<?php if(CCaptcha::checkRequirements()): ?>
					<div class="form-group">
						<p><?php echo $form->label($model,'verifyCode'); ?></p>
						<div class="alert alert-info">
	                        <i class="fa fa-info"></i>
	                        <?php echo CrugeTranslator::t("Por favor escriba los caracteres o dígitos que vea en la <b>imagen</b>.");?>
	                    </div>
						<div>
						<?php $this->widget('CCaptcha'); ?>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock"></i></span>
							<?php echo $form->textField($model,'verifyCode', array('class' => 'form-control')); ?>
						</div>
						</div>
						
						<?php echo $form->error($model,'verifyCode'); ?>
					</div>
					<?php endif; ?>
					
					<div class="form-group buttons">
						<?php Yii::app()->user->ui->tbutton("Recuperar la Clave"); ?>
					</div>
				<?php $this->endWidget(); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
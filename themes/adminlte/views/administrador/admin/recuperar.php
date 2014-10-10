<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle= 'Recuperar contraseña - ' .Yii::app()->name;
?>

<div class="form login col-md-4 col-lg-offset-4">
	<div class="box box-primary">
		<div class="box-header">
		    <h3 class="box-title">Iniciar sesión</h3>
		</div><!-- /.box-header -->
		<!-- form start -->
		<?php 
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'recuperar-form',
			'htmlOptions' => array(
					'role' => 'form', 
				)
		)); 
		?>
		<div class="box-body">
			<div class="form-group">
				<?php echo $form->label($model,'correo'); ?>
				<div class="col-sm-4">
				<?php echo $form->emailField($model,'correo', array('class' => 'form-control')); ?>
				</div>
			</div>
			<div class="form-group buttons">
				<?php echo CHtml::submitButton('Recuperar', array('class' =>'btn btn-primary')); ?>
			</div>
        </div><!-- /.box-body -->
		<?php $this->endWidget(); ?>
	</div><!-- /.box -->
</div><!-- form -->
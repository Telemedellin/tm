<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle= 'Recuperar contraseña - ' .Yii::app()->name;
?>

<div class="form login">
	<h1>Recuperar contraseña</h1>
<?php 
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'recuperar-form',
	'htmlOptions' => array(
			'role' => 'form', 
			'class' => 'form-horizontal', 
		)
)); 
?>
	<div class="form-group">
		<?php echo $form->label($model,'correo', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-4">
		<?php echo $form->emailField($model,'correo', array('class' => 'form-control')); ?>
		</div>
	</div>

	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Recuperar', array('class' =>'btn btn-default')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
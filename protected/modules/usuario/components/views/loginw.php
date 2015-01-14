<?php Yii::app()->clientScript->registerCssFile( Yii::app()->getModule('usuario')->assetsUrl . '/css/usuario.css' ); ?>
<div id="login">
	<?php if( Yii::app()->user->isGuest ): ?>
	<?php Yii::app()->clientScript->registerScript('login-form', 
	    '
	    var login_form  = $(".login-form"), 
	    	login 		= $("#login");
	    $(".login").on("click", function(){
	    	login.addClass("expanded");
	    });
		$(".cerrar").on("click", function(){
			login.removeClass("expanded");
		});
	    ', 
	    CClientScript::POS_READY);
	?>
	<?php $model = $this->getModel(); ?>
	<a href="#" class="login">Inicia sesión</a>
	<div class="login-form">
		<?php $form = $this->beginWidget('CActiveForm', array(
			'id'=>'login-form', 
			'action' => array('/usuario'), 
			'enableAjaxValidation'=>false,
			'htmlOptions' => array(
		        'role' => 'form',
        		'class' => 'form-inline'
		    )
		)); ?>
		<div class="row-fluid">
			<div class="span6">
				<?php echo $form->label($model,'username', array('class' => 'col-sm-2 control-label')); ?>
				<?php echo $form->emailField($model,'username', array('class' => 'form-control')); ?>
			</div>
			<div class="span6">
				<?php echo $form->label($model,'password', array('class' => 'col-sm-2 control-label')); ?>
				<?php echo $form->passwordField($model,'password', array('class' => 'form-control')); ?>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6 offset6 remember">
				<?php echo l('Olvidé mi contraseña', array('/usuario/recuperarclave')); ?>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6 offset3">
				<?php Yii::app()->user->ui->tbutton('Iniciar sesión'); ?>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6 offset3">
				<?php if(Yii::app()->user->um->getDefaultSystem()->getn('registrationonlogin')===1)
					echo l('¿Eres nuevo? Crea tu cuenta', array('/usuario/registro'));
				?>
			</div>
		</div>
		<?php $this->endWidget(); ?>
		<a href="#" class="cerrar"><i class="icon-remove icon-white"></i></a>
	</div>
	<?php else: ?>
	<a href="<?php echo Yii::app()->createUrl('/usuario');?>" class="login">Mi Perfil</a>
	<?php endif; ?>
</div>
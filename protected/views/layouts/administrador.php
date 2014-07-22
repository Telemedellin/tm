<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="language" content="es" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo bu('css'); ?>/styles.admin.min.css" />
	<link rel="shortcut icon" href="<?php echo bu('/favicon.ico')?>" />
	<title><?php echo h($this->pageTitle); ?> - Telemedellín</title>
</head>
<body>
	<div class="container">
		<nav class="navbar navbar-default" role="navigation">
			<div class="navbar-header">
			    <?php echo l( '<span class="glyphicon glyphicon-home"></span> Telemedellín', bu('administrador'), array('class' => 'navbar-brand') ); ?>
			</div>
			<?php if(!Yii::app()->user->isGuest): ?>
			<div class="navbar-collapse navbar-ex1-collapse pull-left">
			    <ul class="nav navbar-nav">
			    	<?php if(Yii::app()->user->checkAccess('ver_novedades')): ?>
			    	<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-bullhorn"></span> Novedades <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo l( '<span class="glyphicon glyphicon-list"></span> Listar', bu('administrador/novedades') ); ?></li>
							<?php if(Yii::app()->user->checkAccess('crear_novedades')): ?>
							<li><?php echo l( '<span class="glyphicon glyphicon-plus"></span> Crear novedad', bu('administrador/novedades/crear') ); ?></li>
							<?php endif ?>		
							<?php if(Yii::app()->user->checkAccess('ver_banners')): ?>
							<li><?php echo l( '<span class="glyphicon glyphicon-list"></span> Banners', bu('administrador/novedades/banners') ); ?></li>
							<?php endif ?>
							<?php if(Yii::app()->user->checkAccess('crear_banners')): ?>
							<li><?php echo l( '<span class="glyphicon glyphicon-plus"></span> Crear banner', bu('administrador/novedades/crearbanner') ); ?></li>
							<?php endif ?>	
						</ul>
					</li>
					<?php endif ?>
					<?php if(Yii::app()->user->checkAccess('ver_concursos')): ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-gift"></span> Concursos <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo l( '<span class="glyphicon glyphicon-list"></span> Listar', bu('administrador/concursos') ); ?></li>
							<?php if(Yii::app()->user->checkAccess('crear_concursos')): ?>
							<li><?php echo l( '<span class="glyphicon glyphicon-plus"></span> Crear nuevo', bu('administrador/concursos/crear') ); ?></li>
							<?php endif ?>
						</ul>
					</li>
					<?php endif ?>
					<?php if(Yii::app()->user->checkAccess('ver_programacion')): ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-calendar"></span> Parrilla <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo l( '<span class="glyphicon glyphicon-list"></span> Listar', bu('administrador/programacion') ); ?></li>
							<?php if(Yii::app()->user->checkAccess('crear_programacion')): ?>
							<li><?php echo l( '<span class="glyphicon glyphicon-plus"></span> Agregar a la parrilla', bu('administrador/programacion/crear') ); ?></li>
							<?php endif ?>
						</ul>
					</li>
					<?php endif ?>
					<?php if(Yii::app()->user->checkAccess('ver_especiales')): ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Especiales <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo l( '<span class="glyphicon glyphicon-list"></span> Listar', bu('administrador/especiales') ); ?></li>
							<?php if(Yii::app()->user->checkAccess('crear_programacion')): ?>
							<li><?php echo l( '<span class="glyphicon glyphicon-plus"></span> Crear nuevo', bu('administrador/especiales/crear') ); ?></li>
							<?php endif ?>
						</ul>
					</li>
					<?php endif ?>
					<?php if(Yii::app()->user->checkAccess('ver_programas')): ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Programas <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo l( '<span class="glyphicon glyphicon-list"></span> Listar', bu('administrador/programas') ); ?></li>
							<?php if(Yii::app()->user->checkAccess('crear_programas')): ?>
							<li><?php echo l( '<span class="glyphicon glyphicon-plus"></span> Crear nuevo', bu('administrador/programas/crear') ); ?></li>
							<?php endif ?>
						</ul>
					</li>
					<?php endif ?>
					<?php if(Yii::app()->user->checkAccess('ver_documentales')): ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Documentales <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo l( '<span class="glyphicon glyphicon-list"></span> Listar', bu('administrador/documentales') ); ?></li>
							<?php if(Yii::app()->user->checkAccess('crear_documentales')): ?>
							<li><?php echo l( '<span class="glyphicon glyphicon-plus"></span> Crear nuevo', bu('administrador/documentales/crear') ); ?></li>
							<?php endif ?>
						</ul>
					</li>
					<?php endif ?>
					<?php if(Yii::app()->user->checkAccess('ver_telemedellin')): ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Telemedellín <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo l( '<span class="glyphicon glyphicon-list"></span> Listar', bu('administrador/telemedellin') ); ?></li>
							<?php if(Yii::app()->user->checkAccess('crear_telemedellin')): ?>
							<li><?php echo l( '<span class="glyphicon glyphicon-plus"></span> Crear micrositio', bu('administrador/telemedellin/crear') ); ?></li>
							<?php endif ?>
						</ul>
					</li>
					<?php endif ?>
					<?php if( Yii::app()->user->isSuperAdmin ): ?>
					<li>
						<a href="<?php echo Yii::app()->user->ui->userManagementAdminUrl ?>">Usuarios <b class="caret"></b></a>
					</li>
					<?php endif ?>
			    </ul>
			</div>
			<p class="navbar-text pull-right">
				<?php echo l( '<span class="glyphicon glyphicon-user"></span>', bu('cruge/ui/editprofile'), array('class' => 'navbar-link', 'title' => Yii::app()->user->getState('correo')) ); ?>
				<?php if( Yii::app()->user->isSuperAdmin ): ?>
				<?php echo l( '<span class="glyphicon glyphicon-refresh"></span>', bu('administrador/borrarcache'), array('class' => 'navbar-link') ); ?>
				<?php endif ?>
				<?php echo l( '<span class="glyphicon glyphicon-off"></span>', bu('administrador/salir'), array('class' => 'navbar-link', 'title' => 'Salir') ); ?>
			</p>
			<?php endif ?>
		</nav>
		<div class="row">
			<section class="col-sm-12">
				<?php echo $content; ?>
			</section>
		</div>
		<!--<footer class="navbar-fixed-bottom">
			<h4>Dudas, problemas o errores:</h4>
			<p>Victor Arias - victor.arias@telemedellin.tv <small>Belmar Santanilla - belmar.santanilla@telemedellin.tv</small></p>
			<p>448 95 90 op. 2 ext. 2013</p>
		</footer>-->
	</div>
<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
<?php 
cs()->coreScriptPosition = CClientScript::POS_END;
cs()->registerCoreScript('jquery');
?>
<?php cs()->registerScriptFile('http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js', CClientScript::POS_END) ?>
<?php cs()->registerScriptFile(bu('/js/admin.libs.min.js'), CClientScript::POS_END); ?>
<?php cs()->registerScriptFile(bu('/js/admin-dev.js'), CClientScript::POS_END); ?>
<?php echo Yii::app()->user->ui->displayErrorConsole(); ?>
</body>
</html>

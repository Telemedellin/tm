<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="language" content="es" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo bu('css'); ?>/styles.admin.min.css" />
	<link rel="shortcut icon" href="<?php echo bu('/favicon.ico')?>" />
	<title><?php echo h($this->pageTitle); ?> - Telemedellínn</title>
</head>
<body>
	<div class="container">
		<nav class="navbar navbar-default" role="navigation">
			<div class="navbar-header">
			    <?php echo l( 'Telemedellín', bu('administrador'), array('class' => 'navbar-brand') ); ?>
			</div>
			<?php if(!Yii::app()->user->isGuest): ?>
			<div class="navbar-collapse navbar-ex1-collapse">
			    <ul class="nav navbar-nav">
			    	<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Novedades <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo l( 'Listar', bu('administrador/novedades') ); ?></li>
							<li><?php echo l( 'Crear nueva', bu('administrador/novedades/crear') ); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Concursos <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo l( 'Listar', bu('administrador/concursos') ); ?></li>
							<li><?php echo l( 'Crear nuevo', bu('administrador/concursos/crear') ); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Parrilla <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo l( 'Listar', bu('administrador/programacion') ); ?></li>
							<li><?php echo l( 'Agregar a la parrilla', bu('administrador/programacion/crear') ); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Especiales <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo l( 'Listar', bu('administrador/especiales') ); ?></li>
							<li><?php echo l( 'Crear nuevo', bu('administrador/especiales/crear') ); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Programas <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo l( 'Listar', bu('administrador/programas') ); ?></li>
							<li><?php echo l( 'Crear nuevo', bu('administrador/programas/crear') ); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Documentales <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo l( 'Listar', bu('administrador/documentales') ); ?></li>
							<li><?php echo l( 'Crear nuevo', bu('administrador/documentales/crear') ); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Telemedellín <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo l( 'Listar', bu('administrador/telemedellin') ); ?></li>
							<li><?php echo l( 'Crear nuevo', bu('administrador/telemedellin/crear') ); ?></li>
						</ul>
					</li>
			    </ul>
			</div>
			<p class="navbar-text pull-right">
				<?php echo Yii::app()->user->getState('correo') ?> 
				<?php echo l( 'Salir', bu('administrador/salir'), array('class' => 'navbar-link') ); ?>
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
<?php cs()->registerScriptFile('http://netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/js/bootstrap.min.js', CClientScript::POS_END) ?>
<?php cs()->registerScriptFile(bu('/js/admin.libs.min.js'), CClientScript::POS_END); ?>
<?php cs()->registerScriptFile(bu('/js/admin-dev.js'), CClientScript::POS_END); ?>
</body>
</html>

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
			    <?php echo l( 'Telemedellín', bu('administrador'), array('class' => 'navbar-brand') ); ?>
			</div>
			<?php if(!Yii::app()->user->isGuest): ?>
			<div class="navbar-collapse navbar-ex1-collapse pull-left">
			    <ul class="nav navbar-nav">
			    	<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Novedades <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo l( '<span class="glyphicon glyphicon-list"></span> Listar', bu('administrador/novedades') ); ?></li>
							<li><?php echo l( '<span class="glyphicon glyphicon-plus"></span> Crear nueva', bu('administrador/novedades/crear') ); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Concursos <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo l( '<span class="glyphicon glyphicon-list"></span> Listar', bu('administrador/concursos') ); ?></li>
							<li><?php echo l( '<span class="glyphicon glyphicon-plus"></span> Crear nuevo', bu('administrador/concursos/crear') ); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-calendar"></span> Parrilla <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo l( '<span class="glyphicon glyphicon-list"></span> Listar', bu('administrador/programacion') ); ?></li>
							<li><?php echo l( '<span class="glyphicon glyphicon-plus"></span> Agregar a la parrilla', bu('administrador/programacion/crear') ); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Especiales <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo l( '<span class="glyphicon glyphicon-list"></span> Listar', bu('administrador/especiales') ); ?></li>
							<li><?php echo l( '<span class="glyphicon glyphicon-plus"></span> Crear nuevo', bu('administrador/especiales/crear') ); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Programas <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo l( '<span class="glyphicon glyphicon-list"></span> Listar', bu('administrador/programas') ); ?></li>
							<li><?php echo l( '<span class="glyphicon glyphicon-plus"></span> Crear nuevo', bu('administrador/programas/crear') ); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Documentales <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo l( '<span class="glyphicon glyphicon-list"></span> Listar', bu('administrador/documentales') ); ?></li>
							<li><?php echo l( '<span class="glyphicon glyphicon-plus"></span> Crear nuevo', bu('administrador/documentales/crear') ); ?></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Telemedellín <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><?php echo l( '<span class="glyphicon glyphicon-list"></span> Listar', bu('administrador/telemedellin') ); ?></li>
							<li><?php echo l( '<span class="glyphicon glyphicon-plus"></span> Crear micrositio', bu('administrador/telemedellin/crear') ); ?></li>
						</ul>
					</li>
			    </ul>
			</div>
			<p class="navbar-text pull-right">
				<?php echo l( '<span class="glyphicon glyphicon-user"></span>', bu('administrador/'), array('class' => 'navbar-link', 'title' => Yii::app()->user->getState('correo')) ); ?>
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
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="language" content="es" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo bu('css'); ?>/styles.admin.min.css" />
	<link rel="shortcut icon" href="favicon.ico" />
	<title><?php echo h($this->pageTitle); ?> - Telemedellín</title>
</head>
<body>
	<div class="container">
		<header>
			<h1><?php echo l( 'Administrador Telemedellín', bu('administrador') ); ?></h1>
		</header>
		<div class="row">
			<nav class="col-lg-3">
				<ul class="nav nav-stacked nav-pills">
					<li>
						<a href="<?php echo bu('administrador/novedades'); ?>">Novedades</a>
						<ul class="nav nav-stacked nav-pills">
							<li>
								<a href="<?php echo bu('administrador/novedades/crear'); ?>">Crear</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="<?php echo bu('administrador/concursos'); ?>">Concursos</a>
						<ul class="nav nav-stacked nav-pills">
							<li>
								<a href="<?php echo bu('administrador/concursos/crear'); ?>">Crear</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="<?php echo bu('administrador/programacion'); ?>">Programación</a>
						<ul class="nav nav-stacked nav-pills">
							<li>
								<a href="<?php echo bu('administrador/programacion/crear'); ?>">Crear</a>
							</li>
						</ul>
					</li>
					<!--<li>
						<a href="<?php echo bu('administrador/micrositio'); ?>">Micrositios</a>
						<ul class="nav nav-stacked nav-pills">
							<li>
								<a href="<?php echo bu('administrador/micrositio/crear'); ?>">Crear</a>
							</li>
						</ul>
					</li>
					<li>
						<a href="<?php echo bu('administrador/pagina'); ?>">Páginas</a>
						<ul class="nav nav-stacked nav-pills">
							<li>
								<a href="<?php echo bu('administrador/pagina/crear'); ?>">Crear</a>
							</li>
						</ul>
					</li>-->
				</ul>
			</nav>
			<section class="col-lg-9">
				<?php echo $content; ?>
			</section>
		</div>
		<footer>&copy; 2013</footer>
	</div>
<?php if( cs()->isScriptFileRegistered( cs()->getCoreScriptUrl() . '/jquery.js', CClientScript::POS_END ) ): ?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<?php endif ?>
<?php cs()->registerScriptFile('http://netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/js/bootstrap.min.js', CClientScript::POS_END) ?>
<?php cs()->registerScriptFile(bu('/js/admin.libs.min.js'), CClientScript::POS_END); ?>
<?php cs()->registerScriptFile(bu('/js/admin-dev.js'), CClientScript::POS_END); ?>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="language" content="es" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--<link rel="stylesheet" type="text/css" href="<?php echo bu('css'); ?>/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo bu('css'); ?>/bootstrap-responsive.min.css" />-->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/css/bootstrap.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo bu('css'); ?>/admin-main.css" />

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
						<a href="<?php echo bu('administrador/url'); ?>">URLs</a>
						<ul class="nav nav-stacked nav-pills">
							<li>
								<a href="<?php echo bu('administrador/url/crear'); ?>">Crear</a>
							</li>
						</ul>
					</li>
					<li>
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
					</li>
				</ul>
			</nav>
			<section class="col-lg-9">
				<?php echo $content; ?>
			</section>
		</div>
		<footer>&copy; 2013</footer>
	</div>
</body>
</html>

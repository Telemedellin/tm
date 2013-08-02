<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="language" content="es" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="<?php echo bu('css'); ?>/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo bu('css'); ?>/bootstrap-responsive.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo bu('css'); ?>/admin-main.css" />

	<title><?php echo h($this->pageTitle); ?> - Telemedellín</title>
</head>
<body>
	<div class="container">
		<header><h1>Administrador Telemedellín</h1></header>
		<section>
			<?php echo $content; ?>
		</section>
		<footer>&copy; 2013</footer>
	</div>
</body>
</html>
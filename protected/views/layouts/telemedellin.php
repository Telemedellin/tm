<?php /* @var $this Controller */ 
$ru = Yii::app()->request->requestUri;
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="<?php echo bu('css'); ?>/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo bu('css'); ?>/bootstrap-responsive.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo bu('css'); ?>/main.css" />
	<!--[if LTE IE 8]>
      <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" />
      <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/modernizr.custom.95570.js"></script>
    <![endif]-->
	<title><?php echo h($this->pageTitle); ?> - Telemedellín</title>
	<?php $this->display_seo(); ?>
</head>

<body <?php if( !count($this->breadcrumbs) ) echo 'class="home"' ?>>
<div id="container">
	<div id="bar">
		<div class="top">
			<header>
				<h1>
					<a href="<?php echo bu(); ?>">
						<img src="<?php echo bu('images/static'); ?>/logo.png" alt="<?php echo app()->name ?>" width="63%" />
					</a>
				</h1>
			</header>
			<nav>
			<?php 
				$this->widget( 'MenuW', array( 'id' => 1 ) ); // Menú principal
		    ?>
			</nav>
			<?php $this->widget('Buscador'); ?>
		</div>
		<footer>
			<div class="vcard">
				<p class="adr">
					<a class="extended-address" href="http://goo.gl/maps/VPIMK">
						<span class="title">Sede principal</span>
						<span class="locality">Barrio Caribe</span> <span class="street-address">Cra 64C N 72-58</span>
					</a>
					<a class="extended-address" href="http://goo.gl/maps/NH7LN">
						<span class="title">Sede canal parque</span>
						<span class="locality">El Poblado</span> <span class="street-address">Cra 43A N 17 sur 30</span>
					</a>
				</p>
				<p>
					<span class="title">Teléfono</span>
					<span class="tel">
						<span class="value">(57 4) 448 9590</span>
					</span>
					<span class="tel">
						<span class="type">Fax</span> 
						<span class="value">(57 4) 437 6930</span>
					</span>
				</p>
				<p>
					<span class="title">Correo electrónico</span>
					<span class="email">contacto@telemedellin.tv</span>
				</p>
			</div>
			<div class="redes">
				<ul>
					<li class="facebook"><a href="http://www.facebook.com/telemedellin.tv‎">Facebook</a></li>
					<li class="twitter"><a href="http://www.twitter.com/telemedellin">Twitter</a></li>
					<li class="flickr"><a href="http://www.flickr.com/telemedellin">Flickr</a></li>
					<li class="youtube"><a href="http://www.youtube.com/user/telemedellin‎">Youtube</a></li>
					<li class="foursquare"><a href="https://es.foursquare.com/telemedellin">Foursquare</a></li>
					<li class="instagram"><a href="http://instagram.com/telemedellin">Instagram</a></li>
				</ul>
			</div>
			<?php echo l( 'Escríbenos' , CHtml::normalizeUrl(Yii::app()->homeUrl . 'escribenos'), array('class' => 'escribenos') ); ?>
		</footer>
	</div>
	<?php $this->widget('ProgramacionW'); ?>
	<div id="content">
		<?php if( count($this->breadcrumbs) ): ?>
	      <?php 
	        $this->widget( 'zii.widgets.CBreadcrumbs', 
	          array(
	            'homeLink' => CHtml::link( 'Inicio' , CHtml::normalizeUrl(Yii::app()->homeUrl) ),
	            'separator'=> '',
	            'links'    => $this->breadcrumbs,
	            'inactiveLinkTemplate' => '<h1>{label}</h1>',
	          )
	        ); 
	      ?><!-- breadcrumbs -->
	    <?php endif; ?>
		<?php echo $content; ?>
	</div>
	<div id="second-nav">
		<?php 
			$this->widget( 'MenuW', array( 'id' => 4 ) ); // Menú utilitario
	      ?>
	</div>
</div>
</body>
</html>
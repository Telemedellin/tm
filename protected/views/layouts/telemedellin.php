<?php /* @var $this Controller */ 
$ru = Yii::app()->request->requestUri;
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script>
	var n = navigator.userAgent.toLowerCase();
	if( n.search(/android|blackberry|iphone|ipod|iemobile|opera mobile|palmos|webos/) > -1 ){
		document.location = 'http://m.telemedellin.tv';
	}

	</script>
	<link rel="stylesheet" type="text/css" href="<?php echo bu('css'); ?>/libs/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo bu('css'); ?>/libs/bootstrap-responsive.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo bu('css'); ?>/libs/jquery.fancybox.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo bu('css'); ?>/main.css" />
	<!--[if LTE IE 9]>
	  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie9.css" />
	  <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/libs/ie/html5shiv.js"></script>
	<![endif]-->
	<!--[if LTE IE 8]>
	  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" />
	<![endif]-->
	<link rel="shortcut icon" href="<?php echo bu('/favicon.ico')?>" />
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
						<img src="<?php echo bu('images/static'); ?>/logo.png" alt="<?php echo app()->name ?>" width="80%" />
					</a>
				</h1>
			</header>
			<nav>
			<?php 
				$this->widget( 'MenuW', array( 'id' => 1 ) ); // Menú principal
		    ?>
			</nav>
			<?php //$this->widget('ext.tm-buscador.TmBuscador'); ?>
		</div>
		<footer>
			<div class="redes">
				<ul>
					<li class="facebook"><a href="http://www.facebook.com/telemedellin.tv‎" target="_blank">Facebook</a></li>
					<li class="twitter"><a href="http://www.twitter.com/telemedellin" target="_blank">Twitter</a></li>
					<li class="flickr"><a href="http://www.flickr.com/telemedellin" target="_blank">Flickr</a></li>
					<li class="youtube"><a href="http://www.youtube.com/user/telemedellin‎" target="_blank">Youtube</a></li>
					<li class="foursquare"><a href="https://es.foursquare.com/telemedellin" target="_blank">Foursquare</a></li>
					<li class="instagram"><a href="http://instagram.com/telemedellin" target="_blank">Instagram</a></li>
				</ul>
			</div>
			<?php echo l( 'Contacto' , CHtml::normalizeUrl(Yii::app()->homeUrl . 'telemedellin/utilidades/escribenos'), array('class' => 'escribenos') ); ?>
		</footer>
	</div>
	
	<div id="content">
		<?php if( count($this->breadcrumbs) ): ?>
	      <?php 
	        $this->widget( 'zii.widgets.CBreadcrumbs', 
	          array(
	            'homeLink' => CHtml::link( 'Inicio' , CHtml::normalizeUrl(Yii::app()->homeUrl), array('class' => 'home') ),
	            'separator'=> '',
	            'links'    => $this->breadcrumbs,
	            'inactiveLinkTemplate' => '<h1>{label}</h1>',
	          )
	        ); 
	      ?><!-- breadcrumbs -->
	    <?php endif; ?>
		<?php echo $content; ?>
	</div>
	<?php $this->widget('ProgramacionW'); ?>
	<?php 
		if( !count($this->breadcrumbs) )
			$this->widget('NewsTicker'); ?>
	<?php 
	if( count($this->breadcrumbs) )
		$this->widget('Compartir'); 
	?>
</div>
<div id="dots"></div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/libs.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app.min.js"></script>
<!--[if LTE IE 9]>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/libs/ie/native.history.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/libs/ie/css3-multi-column.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/libs/ie/jquery.marquee.js"></script>
<script>$('.marquesina').marquee('marquesina');</script>
<![endif]-->
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-5650687-11']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</body>
</html>
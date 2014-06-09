<?php /* @var $this Controller */ 
cs()->coreScriptPosition 		= CClientScript::POS_END;
cs()->defaultScriptFilePosition = CClientScript::POS_END;
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="stylesheet" type="text/css" href="<?php echo bu('css/styles.min.css'); ?>" />
	<!--[if LTE IE 9]>
	  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie9.css" />
	  <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/libs/ie/html5shiv.js"></script>
	<![endif]-->
	<!--[if LTE IE 8]>
	  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" />
	<![endif]-->
	<?php $this->display_seo($this->pageTitle); //SEO?>
</head>
<body <?php if( !count($this->breadcrumbs) ) echo 'class="home"' ?>>
<div id="container">
	<div id="bar">
		<div class="top">
			<header>
				<h1>
					<a href="<?php echo bu('/'); ?>">
						<img src="<?php echo bu('images/static'); ?>/logo.png" alt="Telemedellín, aquí te ves" title="Ir a la página de inicio de Telemedellín" width="80%" />
					</a>
				</h1>
			</header>
			<nav>
			<?php 
				$this->widget( 'MenuW', array( 'id' => 1 ) ); // Menú principal
		    ?>
			</nav>
		</div>
		<?php $this->renderPartial('/layouts/_footer'); ?>
	</div>
	<div id="content">
	<?php if( count($this->breadcrumbs) ): ?>
	<?php 
	$this->widget( 'zii.widgets.CBreadcrumbs', 
	  array(
	    'homeLink' => CHtml::link( '<span itemprop="title">Inicio</span>', CHtml::normalizeUrl(Yii::app()->homeUrl), array('class' => 'home', 'itemprop' => 'url') ),
	    'separator'=> '',
	    'links'    => $this->breadcrumbs,
	    'inactiveLinkTemplate' => '<h1>{label}</h1>',
	    'activeLinkTemplate' => '<a href="{url}" itemprop="url"><span itemprop="title">{label}</span></a>',
	    'htmlOptions' => array('class' => 'breadcrumbs', 'itemscope' => '', 'itemtype' => 'http://data-vocabulary.org/Breadcrumb'),
	  )
	); 
	?>
    <?php endif; ?>
	<?php echo $content; ?>
	</div>
	<?php $this->widget('ProgramacionW'); ?>
	<?php 
	if( !count($this->breadcrumbs) )
		$this->widget('NewsTicker');
	if( count($this->breadcrumbs) )
		$this->widget('Compartir'); 
	?>
	<?php 
	if( !count($this->breadcrumbs) )
		$this->widget('BannerW');
	?>
</div>
<div class="dots"></div>
<?php cs()->registerCoreScript('jquery'); ?>
<?php cs()->registerScriptFile(bu('/js/libs.min.js'), CClientScript::POS_END);?>
<?php cs()->registerScriptFile(bu('/js/app.min.js'), CClientScript::POS_END);?>
<!--[if LTE IE 9]>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/ie.js"></script>
<script>$('.marquesina').marquee('marquesina');</script>
<![endif]-->
<?php $this->renderPartial('/layouts/_analytics'); ?>
</body>
</html>
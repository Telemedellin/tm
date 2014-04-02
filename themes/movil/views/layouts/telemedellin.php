<?php /* @var $this Controller */ 
cs()->coreScriptPosition 		= CClientScript::POS_END;
cs()->defaultScriptFilePosition = CClientScript::POS_END;
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="stylesheet" type="text/css" href="<?php echo bu('css/mobile.min.css'); ?>" />
	<?php $this->display_seo($this->pageTitle); //SEO ?>
</head>
<body <?php if( !count($this->breadcrumbs) ) echo 'class="home"' ?>>
<div id="container">
	<header>
		<h1>
			<a href="<?php echo bu('/'); ?>">
				<img src="<?php echo bu('images/static'); ?>/logo-mobile.png" alt="Telemedellín, aquí te ves" title="Ir a la página de inicio de Telemedellín" width="100%" />
			</a>
		</h1>
	</header>
	<?php $this->widget('ProgramacionW', array('layout' => 'mobile') ); ?>
	<a href="#" id="menu-link">Menú</a>
	<?php echo $content; ?>
	<?php 
	if( !count($this->breadcrumbs) )
		$this->widget('NewsTicker', array('layout' => 'mobile'));
	if( count($this->breadcrumbs) )
		$this->widget('Compartir'); 
	?>
	<?php $this->renderPartial('/layouts/_footer'); ?>
</div>
<div class="dots"></div>
<nav>
<?php $this->widget( 'MenuM', array( 'id' => 1 ) ); // Menú principal ?>
</nav>
<?php cs()->registerCoreScript('jquery'); ?>
<?php cs()->registerScriptFile(bu('/js/mobile.libs.min.js'), CClientScript::POS_END);?>
<?php cs()->registerScriptFile(bu('/js/mobile.min.js'), CClientScript::POS_END);?>
<?php $this->renderPartial('/layouts/_analytics'); ?>
</body>
</html>
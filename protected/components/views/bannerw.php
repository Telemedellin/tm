<?php cs()->registerCoreScript('jquery'); ?>
<?php if($banner = $this->getBanner()): ?>
<div id="banner">
    <?php if(!is_null($banner->url) && !empty($banner->url)): ?><a href="<?php echo $banner->url ?>"><?php endif ?>
	<?php if( $banner->contador ):?>
		<div id="contador" data-fin="<?php echo strtotime($banner->fin_contador)?>"></div>
		<div class="txt_conta" style="font-size: <?php echo $banner->tamano?>px; font-family: <?php echo $banner->fuente ?>; color: <?php echo $banner->color ?>; "></div>
	<?php endif ?>
	<img src="<?php echo bu('/images/' . $banner->imagen); ?>" alt="<?php echo str_replace('"', "'", $banner->nombre); ?>" />
    <?php if(!is_null($banner->url) && !empty($banner->url)): ?></a><?php endif ?>
</div>
<?php endif; ?>
<?php cs()->registerCoreScript('jquery'); ?>
<?php if($banner = $this->getBanner()): ?>
<div id="banner">
  <a class="close" href="#">Cerrar</a>
  <?php if(!is_null($banner->url) && !empty($banner->url)): ?><a href="<?php echo $banner->url ?>"><?php endif ?>
    <div id="contador" class="horas"></div>
    <img src="<?php echo bu('/images/' . $banner->imagen_mobile); ?>" alt="<?php echo str_replace('"', "'", $banner->nombre); ?>" />
  <?php if(!is_null($banner->url) && !empty($banner->url)): ?></a><?php endif ?>
</div>
<?php endif; ?>
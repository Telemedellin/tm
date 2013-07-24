<?php
cs()->registerScriptFile(bu().'/js/jquery.superslides/jquery.superslides.js', CClientScript::POS_END);
cs()->registerScript(
  'novedades', 
  '$("#novedades").superslides({
    animation: "fade",
    play: 5000,
    hashchange: true
  });
  $("#novedades").on("mouseenter", function() {
    $(this).superslides("stop");
  });
  $("#novedades").on("mouseleave", function() {
    $(this).superslides("start");
  });', 
  CClientScript::POS_READY
);
?>
<div id="novedades">
  <ul class="novedades slides-container">
    <?php foreach($this->getNovedades() as $novedad): ?>
    <li class="novedad">
      <img src="<?php echo bu() . '/' . $novedad['contenido']->imagen; ?>" alt="<?php echo $novedad['contenido']['titulo']; ?>" />
      <div class="container">
        <h3><?php echo $novedad['contenido']['titulo']; ?></h3>
        <p><?php echo $novedad['contenido']['entradilla']; ?></p>
        <a href="<?php echo bu() . '/novedades/' . $novedad['pagina']->slug ?>" class="ver-mas">Ver más</a>
      </div>
    </li>
    <?php endforeach ?>
</div>
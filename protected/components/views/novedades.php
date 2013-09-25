<?php
cs()->registerScriptFile(bu().'/js/libs/jquery.superslides.js', CClientScript::POS_END);
cs()->registerScript(
  'novedades', 
  '$("#novedades").superslides({
    animation: "fade",
    play: 5000,
    //hashchange: true,
    pagination: false
  });
  set_current();
  $("#novedades").on("mouseenter", function() {
    $(this).superslides("stop");
  });
  $("#novedades").on("mouseleave", function() {
    $(this).superslides("start");
  });
  $("#novedades").on("started.slides", function(){
    set_current();
  });
  $("#novedades").on("animated.slides", function(){
    set_current();
  });
  function set_current()
  {
    var current = $("#novedades").superslides("current");
    $( ".slides-pagination a" ).each(function( index ) {
      $(this).removeClass("current");
    });
    $(".slides-pagination ." + current).addClass("current");
  }
  ',
  CClientScript::POS_READY
);
?>
<div id="novedades">
  <ul class="novedades slides-container">
  <?php 
    $paginador = ''; 
    $i         = 0;
    foreach($this->getNovedades() as $novedad): ?>
    <li class="novedad">
      <img src="<?php echo bu() . '/' . $novedad['contenido']->imagen; ?>" alt="<?php echo $novedad['pagina']->nombre; ?>" />
      <div class="container">
        <h3><?php echo $novedad['pagina']->nombre; ?></h3>
        <p><?php echo $novedad['contenido']['entradilla']; ?></p>
        <a href="<?php echo bu($novedad['pagina']->url->slug) ?>" class="ver-mas">Ver más de <?php echo $novedad['pagina']->nombre; ?></a>
      </div>
    </li>
    <?php 
    $paginador .= '<a class="'.$i.'" href="#'.($i+1).'"><img src="'. bu() . '/' . $novedad['contenido']->miniatura .'" /></a>' . "\r\n";
    $i++;
    endforeach;
    ?>
  </ul>
  <nav class="slides-pagination">
    <?php echo $paginador; ?>
  </nav>
</div>

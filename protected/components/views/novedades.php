<?php
cs()->registerScriptFile(bu('/js/libs/jquery.superslides.js'), CClientScript::POS_END);
cs()->registerScript(
  'novedades', 
  '$("#novedades").superslides({
    animation: "fade",
    play: 15000,
    //hashchange: true,
    pagination: false
  });
  set_current();
  $("#novedades").on("mouseenter", function() {
    $(this).superslides("stop");
  });
  $("#novedades").on("mouseleave", function() {
    setTimeout(function(){$(this).superslides("start");}, 15000);
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
      <img src="<?php echo bu('/images/' . $novedad->pgArticuloBlogs->imagen); ?>" alt="<?php echo $novedad->nombre; ?>" />
      <div class="container">
        <h3><?php echo $novedad->nombre; ?></h3>
        <p><?php echo $novedad->pgArticuloBlogs->entradilla; ?></p>
        <?php $enlace = ( $novedad->pgArticuloBlogs->enlace == '' )? bu($novedad->url->slug):$novedad->pgArticuloBlogs->enlace;?>
        <a href="<?php echo $enlace ?>" class="ver-mas">Ver más de <?php echo $novedad->nombre; ?></a>
      </div>
    </li>
    <?php 
    $paginador .= '<a class="'.$i.'" href="#'.($i+1).'"><img src="'. bu('/images/' . $novedad->pgArticuloBlogs->miniatura) . '" /></a>' . "\r\n";
    $i++;
    endforeach;
    ?>
  </ul>
  <nav class="slides-pagination">
    <?php echo $paginador; ?>
  </nav>
</div>

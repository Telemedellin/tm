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
<!--    <li class="novedad">
      <img src="<?php echo bu('images/novedades'); ?>/background1.jpg" alt="Conoce nuestro nuevo portal Web" />
      <div class="container">
        <h3>Conoce nuestro nuevo portal Web</h3>
        <p>Viernes 2:00 p.m. Un programa de ISVIMED para que aprendamos a resolver problemáticas comunitarias.</p>
        <a href="#" class="ver-mas">Ver más</a>
      </div>
    </li>
    <li class="novedad">
      <img src="<?php echo bu('images/novedades'); ?>/background2.jpg" alt="Estreno Telemedellín Vecinos y amigos" />
      <div class="container">
        <h3>Estreno Telemedellín Vecinos y amigos</h3>
        <p>Viernes 2:00 p.m. Un programa de ISVIMED para que aprendamos a resolver problemáticas comunitarias.</p>
        <a href="#" class="ver-mas">Ver más</a>
      </div>
    </li>
    <li class="novedad">
      <img src="<?php echo bu('images/novedades'); ?>/background3.jpg" alt="Conoce nuestro nuevo portal Web" />
      <div class="container">
        <h3>Conoce nuestro nuevo portal Web</h3>
        <p>Viernes 2:00 p.m. Un programa de ISVIMED para que aprendamos a resolver problemáticas comunitarias.</p>
        <a href="#" class="ver-mas">Ver más</a>
      </div>
    </li>
    <li class="novedad">
      <img src="<?php echo bu('images/novedades'); ?>/background4.jpg" alt="Estreno Telemedellín Vecinos y amigos" />
      <div class="container">
        <h3>Estreno Telemedellín Vecinos y amigos</h3>
        <p>Viernes 2:00 p.m. Un programa de ISVIMED para que aprendamos a resolver problemáticas comunitarias.</p>
        <a href="#" class="ver-mas">Ver más</a>
      </div>
    </li>
    <li class="novedad">
      <img src="<?php echo bu('images/novedades'); ?>/background5.jpg" alt="Conoce nuestro nuevo portal Web" />
      <div class="container">
        <h3>Conoce nuestro nuevo portal Web</h3>
        <p>Viernes 2:00 p.m. Un programa de ISVIMED para que aprendamos a resolver problemáticas comunitarias.</p>
        <a href="#" class="ver-mas">Ver más</a>
      </div>
    </li>
    <li class="novedad">
      <img src="<?php echo bu('images/novedades'); ?>/background0.jpg" alt="Estreno Telemedellín Vecinos y amigos" />
      <div class="container">
        <h3>Estreno Telemedellín Vecinos y amigos</h3>
        <p>Viernes 2:00 p.m. Un programa de ISVIMED para que aprendamos a resolver problemáticas comunitarias.</p>
        <a href="#" class="ver-mas">Ver más</a>
      </div>
    </li>
    <li class="novedad">
      <img src="<?php echo bu('images/novedades'); ?>/background1.jpg" alt="Conoce nuestro nuevo portal Web" />
      <div class="container">
        <h3>Conoce nuestro nuevo portal Web</h3>
        <p>Viernes 2:00 p.m. Un programa de ISVIMED para que aprendamos a resolver problemáticas comunitarias.</p>
        <a href="#" class="ver-mas">Ver más</a>
      </div>
    </li>
  </ul>
  <!--<nav class="slides-navigation">
    <a href="#" class="next">Siguiente</a>
    <a href="#" class="prev">Anterior</a>
  </nav>-->
</div>
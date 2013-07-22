<?php
cs()->registerScriptFile(bu().'/js/jquery.superslides/jquery.superslides.min.js', CClientScript::POS_END);
cs()->registerScript(
  'novedades', 
  '$("#novedades").superslides({container: ".novedades"});', 
  CClientScript::POS_READY
);
?>
<section id="novedades">
  <h2 class="visible-phone">Novedades Telemedellín</h2>
  <div class="novedades">
    <article class="novedad">
      <h3>Estreno Telemedellín Vecinos y amigos</h3>
      <img src="<?php echo bu('images/novedades'); ?>/background0.jpg" width="1920" height="1080" alt="Estreno Telemedellín Vecinos y amigos" />
      <p>Viernes 2:00 p.m. Un programa de ISVIMED para que aprendamos a resolver problemáticas comunitarias.</p>
      <a href="#" class="ver-mas">Ver más</a>
    </article>
    <article class="novedad">
      <h3>Conoce nuestro nuevo portal Web</h3>
      <img src="<?php echo bu('images/novedades'); ?>/background1.jpg" width="1920" height="1080" alt="Conoce nuestro nuevo portal Web" />
      <p>Viernes 2:00 p.m. Un programa de ISVIMED para que aprendamos a resolver problemáticas comunitarias.</p>
      <a href="#" class="ver-mas">Ver más</a>
    </article>
  </div>
  <footer class="visible-phone">
    <a href="novedades">Ver todas las novedades</a>
  </footer>
</section>
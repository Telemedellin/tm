<section id="newsticker">
  <h2>Noticias Telemedellín</h2>
<?php
$this->widget(
       'ext.yii-feed-widget.YiiFeedWidget',
       array('url'=>'http://noticias.telemedellin.tv/feed', 'limit'=>10)
    );

cs()->registerScriptFile(bu().'/js/jquery.bxslider/jquery.bxslider.js', CClientScript::POS_END);
/*cs()->registerScript(
  'newsticker', 
  '$(".noticias").bxSlider({
    slideWidth: 230,
    minSlides: 3,
    maxSlides: 4,
    pager: false,
    vaMaxWidth: "79%"
    //,slideMargin: 7
  });', 
  CClientScript::POS_READY
);
?>
<section id="newsticker">
  <h2>Noticias Telemedellín</h2>
  <div class="noticias">
    <article class="noticia">
      <img src="http://lorempixel.com/25/25/city" width="25" height="25" alt="Medellín busca los mejores bailadores..." />
      <h3>Hay gente para la que el "día sin carro", es todos los días</h3>
      <div class="meta"><time>20 Nov, 10:00</time> - <span>Valle del Aburrá</span></div>
    </article>
    <article class="noticia">
      <img src="http://lorempixel.com/25/25/city" width="25" height="25" alt="En mayo comienza la renovación de Ayacucho" />
      <h3>En mayo comienza la renovación de Ayacucho</h3>
      <div class="meta"><time>24 Abr, 17:15</time> - <span>Medellín</span></div>
    </article>
    <article class="noticia">
      <img src="http://lorempixel.com/25/25/city" width="25" height="25" alt="\"Bolillo\" Gómez será consultor deportivo en DIM" />
      <h3>"Bolillo" Gómez será consultor deportivo en DIM</h3>
      <div class="meta"><time>24 Abr, 17:32</time> <span>Deportes</span></div>
    </article>
  </div>
  <footer>
    <a href="noticias">Ver todas las noticias</a>
  </footer>
</section>
*/?>
  <footer>
    <a href="http://noticias.telemedellin.tv/">Ver todas las noticias</a>
  </footer>
</section>
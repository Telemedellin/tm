<section id="newsticker">
  <h2>Noticias Telemedellín</h2>
<?php
$this->widget(
       'ext.yii-feed-widget.YiiFeedWidget',
       array('url'=>'http://noticias.telemedellin.tv/feed', 'limit'=>10)
    );

cs()->registerScriptFile(bu().'/js/jquery.bxslider/jquery.bxslider.js', CClientScript::POS_END);
?>
  <footer>
    <a href="http://noticias.telemedellin.tv/">Ver todas las noticias</a>
  </footer>
</section>
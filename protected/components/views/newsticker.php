<section id="newsticker">
 
  <footer>
    <a href="http://noticias.telemedellin.tv/"><img src="/tm/images/static/noticiastm.png" alt="Telemedellín" width="83%"></a>
  </footer>
<?php
$this->widget(
       'ext.yii-feed-widget.YiiFeedWidget',
       array('url'=>'http://noticias.telemedellin.tv/feed', 'limit'=>10)
    );

cs()->registerScriptFile(bu().'/js/libs/jquery.bxslider/jquery.bxslider.js', CClientScript::POS_END);
?>

<div class="marquesina">
	<div>
		<p>En #NTMed comenzamos a prepararnos, porque lo que pasa en Medellín se ve primero en @Telemedellin pic.twitter.com/LwSpLD7wv2</p>
		<p>Desde el Estadio Atanasio Girardot tendremos un avance de #NTMed con todos los detalles del concierto de Beyoncé a las 12: 59 p.m.</p>
		<p>Medellín se prepara para otros megaconciertos, Paul McCartney en la lista. #NTMed http://ow.ly/p67lq </p>
		<p>Hoy #NTMed tuvo la oportunidad de hablar con John Lee Anderson sobre el trabajo que desearía hacer en Colombia. A las 7:25 p.m @Telemedellin</p>
	</div>
</div>
  
</section>
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
		<?php for($i=0; $i<count($tweets); $i++): ?>
			<p><a href="https://twitter.com/search?q=%23NTMed" target="_blank" rel="nofollow"><?php echo $tweets[$i] ?></a></p>
		<?php endfor; ?>

	</div>
</div>
  
</section>
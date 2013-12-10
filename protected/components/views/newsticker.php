<section id="newsticker">
  <footer>
    <a href="http://noticias.telemedellin.tv/" target="_blank"><img src="/images/static/noticiastm.png" alt="Telemedellín" width="83%"></a>
  </footer>
<?php
$this->widget(
       'ext.yii-feed-widget.YiiFeedWidget',
       array('url'=>'http://noticias.telemedellin.tv/feed', 'limit'=>10)
    );
//cs()->registerScriptFile(bu().'/js/libs/jquery.bxslider/jquery.bxslider.js', CClientScript::POS_END);
?>
<div class="marquesina">
	<div>
		<?php 
    if(!empty($tweets)):
      for($i=0; $i<count($tweets); $i++): ?>
			<p><?php echo $tweets[$i] ?></p>
		<?php 
      endfor; 
    endif;?>
	</div>
</div>
  
</section>
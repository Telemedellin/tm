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
		<?php foreach($tweets as $tweet): /*print_r($tweet);*/?>
      <?php 
        $texto = $tweet->text;
        if( count($tweet->entities->hashtags) )
        {
          foreach ($tweet->entities->hashtags as $hashtag) {
            $nh = '<s>#</s><b class="hashtag">' . $hashtag->text . '</b>';
            $texto = substr_replace($texto, $nh, $hashtag->indices[0], $hashtag->indices[1]);
          }
        }
        if( count($tweet->entities->user_mentions) )
        {
          foreach ($tweet->entities->user_mentions as $user_mention) {
            $num = '<s>@</s><b class="user_mention">' . $user_mention->screen_name . '</b>';
            $texto = substr_replace($texto, $num, $user_mention->indices[0], $user_mention->indices[1]);
          }
        }
      ?>
			<p><a href="https://twitter.com/search?q=%23NTMed" target="_blank" rel="nofollow"><?php echo $texto ?></a></p>
		<?php endforeach; ?>

	</div>
</div>
  
</section>
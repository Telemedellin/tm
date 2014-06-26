<section id="newsticker">
  <?php if($layout == 'pc'): ?>
  <footer>
    <h2><a href="http://noticias.telemedellin.tv/" target="_blank" class="todas-las-noticias" title="Ir al portal de Noticias Telemedellín">Ver todas las noticias</a></h2>
  </footer>
  <?php else: ?>
  <h2>Noticias</h2>
  <?php endif; ?>
<?php
$limit = ($layout == 'pc')?10:5;
$this->widget(
       'ext.yii-feed-widget.YiiFeedWidget',
       array('url'=>'http://noticias.telemedellin.tv/feed', 'limit'=>$limit, 'layout'=>$layout)
    );
?>
<?php if(!empty($tweets)): ?>
<div class="marquesina">
	<div>
		<?php for($i=0; $i<count($tweets); $i++): ?>
			<p><?php echo $tweets[$i] ?></p>
		<?php endfor; ?>
	</div>
</div>
<?php endif; ?>
<?php if($layout != 'pc'): ?>
<a href="http://noticias.telemedellin.tv/" target="_blank" class="ver-mas todas-las-noticias" title="Ir al portal de Noticias Telemedellín">Ver todas las noticias</a>
<?php endif; ?>
</section>
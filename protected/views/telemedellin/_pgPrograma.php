<p><strong><?php echo $contenido['contenido']->horario ?></strong></p>
<h3>Resena</h3>
<p><?php echo $contenido['contenido']->resena ?></p>

<?php if( $contenido['contenido']->promo ): ?>
	<h3>Esta semana</h3>
<?php 
	preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $contenido['contenido']->promo, $matches);
	if(isset($matches[1])):
?> 
		<iframe type="text/html" width="350" height="200" src="http://www.youtube.com/embed/<?php echo $matches[1] ?>?rel=0" frameborder="0"></iframe>		
	<?php endif; ?>
<?php endif; ?>
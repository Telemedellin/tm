<?php
$code = Yii::app()->errorHandler->error["code"];
$this->pageTitle = 'Página no encontrada (Error '.$code.')';
$this->breadcrumbs = array('Página no encontrada (Error '.$code.')');
cs()->registerScript('trackEvent', 
	'
	ga("send", "event", "Error", "'.$code.'", location.pathname);
	');
if($this->beginCache( $code, array('duration' => 21600) )):
?>
<div id="micrositio">
	<div class="contenidoScroll">
		<h2>Error <?php echo $code ?></h2>
		<p>¿No encontraste lo que buscabas?</p>
		<p>Si querés pegate una pasada por nuestros <?php echo l('programas', bu('programas')) ?> o nuestra <?php echo l('parrilla de programación', bu('programacion')) ?>.</p>
		<p>Si todavía no encontrás lo que buscas, podés preguntarnos en nuestras redes sociales:</p>
		<ul>
			<li><?php echo l('Twitter', CHtml::normalizeUrl('http://twitter.com/telemedellin'), array('target' => '_blank', 'rel' => 'nofollow') ) ?></li>
			<li><?php echo l('Facebook', CHtml::normalizeUrl('http://facebook.com/telemedellintv'), array('target' => '_blank', 'rel' => 'nofollow')) ?></li>
		</ul>
		<p>O también podés <?php echo l('escribirnos', bu('telemedellin/utilidades/escribenos')) ?></p>
	</div>
</div>
<?php $this->endCache(); endif; ?>